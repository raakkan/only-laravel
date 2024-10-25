<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use OpenAI;

trait InteractsWithOpenAI
{
    public function generateWithAI(array $data, $json = true)
    {
        $apiKey = decrypt(setting('onlylaravel.ai.openai_api_key'));

        $requiredKeys = ['ai_model', 'ai_prompt', 'max_tokens', 'temperature'];
        foreach ($requiredKeys as $key) {
            if (! isset($data[$key])) {
                Notification::make()
                    ->title('Error')
                    ->body("Missing required field: {$key}")
                    ->danger()
                    ->send();

                return '';
            }
        }

        $model = $data['ai_model'];
        $prompt = $data['ai_prompt'];
        $maxTokens = is_string($data['max_tokens']) ? intval($data['max_tokens']) : $data['max_tokens'];
        $temperature = is_string($data['temperature']) ? floatval($data['temperature']) : $data['temperature'];

        return $this->generateContentWithAI($apiKey, $model, $prompt, $maxTokens, $temperature, $json);
    }

    private function generateContentWithAI($apiKey, $model, $prompt, $maxTokens, $temperature, $json)
    {
        try {
            $client = OpenAI::client($apiKey);

            $response = $client->chat()->create([
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
                'response_format' => [
                    'type' => $json ? 'json_object' : 'text',
                ],
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            Log::error('Error generating content with AI: '.$e->getMessage());
            \Log::error('Stack trace: '.$e->getTraceAsString());

            return null;
        }
    }

    public function apiKeyIsValid($apiKey)
    {
        $client = OpenAI::client($apiKey);

        try {
            $client->models()->retrieve('gpt-4o-mini');

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function getGenerateWithAIFormSchema($state = null): array
    {
        return [
            Forms\Components\Select::make('ai_model')
                ->label('AI Model')
                ->options([
                    'gpt-4o-mini' => 'GPT-4o Mini',
                    'gpt-4o' => 'GPT-4o',
                    'gpt-4-turbo' => 'GPT-4 Turbo',
                    'gpt-4' => 'GPT-4',
                    'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
                ])
                ->required(),
            Forms\Components\Textarea::make('ai_prompt')
                ->label('AI Prompt')
                ->default($state)
                ->required(),
            Forms\Components\Section::make('Advanced Settings')
                ->schema([
                    Forms\Components\TextInput::make('max_tokens')
                        ->label('Max Tokens')
                        ->default(2000)
                        ->numeric(),
                    Forms\Components\TextInput::make('temperature')
                        ->label('Temperature')
                        ->default(0.5)
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(1)
                        ->step(0.1),
                ])
                ->collapsed()->compact()->columns(2),
        ];
    }

    protected function getFieldActions($field, $withState = false): array
    {
        $apiKey = null;
        $actions = [];

        if (setting('onlylaravel.ai.openai_api_key')) {
            $apiKey = decrypt(setting('onlylaravel.ai.openai_api_key'));
        }

        if ($apiKey && isset($apiKey) && $this->apiKeyIsValid($apiKey)) {
            $actions[] = Action::make('ai')
                ->label($withState ? 'Regenerate With AI' : 'Generate With AI')
                ->action(function (array $data) use ($field) {
                    $generatedContent = $this->generateWithAI($data, false);

                    if (empty($generatedContent)) {
                        Notification::make()
                            ->title('Error')
                            ->body('Failed to generate content. Please try again.')
                            ->danger()
                            ->send();
                        Log::error('Failed to generate content with AI: '.json_decode($generatedContent));

                        return;
                    }
                    $this->form->fill([
                        $field => $generatedContent,
                    ]);
                })
                ->form($this->getGenerateWithAIFormSchema($withState ? $this->buildPromptForField($field) : null))
                ->modalSubmitActionLabel('Generate');
        }

        return $actions;
    }

    protected function buildPromptForField($field)
    {
        $prompt = "regenerate the following text:\n";
        $prompt .= $this->getRecord()->$field;

        return $prompt;
    }
}

<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use OpenAI;
use Filament\Forms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait InteractsWithOpenAIImage
{
    public function generateImageWithAI(array $data, string $folderName, string $fieldName)
    {
        $apiKey = decrypt(setting('onlylaravel.ai.openai_api_key'));
        
        $requiredKeys = ['prompt', 'size', 'quality', 'style'];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                Notification::make()
                    ->title('Error')
                    ->body("Missing required field: {$key}")
                    ->danger()
                    ->send();
                return null;
            }
        }

        return $this->generateAndStoreImageWithAI($apiKey, $data['prompt'], $data['size'], $data['quality'], $data['style'], $fieldName);
    }

    private function generateAndStoreImageWithAI($apiKey, $prompt, $size, $quality, $style, $fieldName)
    {
        try {
            $client = OpenAI::client($apiKey);

            $response = $client->images()->create([
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'size' => $size,
                'quality' => $quality,
                'style' => $style,
                'n' => 1,
            ]);

            $imageUrl = $response->data[0]->url;
            
            // Download the image
            $imageContents = file_get_contents($imageUrl);
            $filename = Str::random(40) . '.png';
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            file_put_contents($tempPath, $imageContents);

            /** @var FileUpload $fileUploadComponent */
            $fileUploadComponent = $this->form->getComponent($fieldName);

            // Get the storage disk and directory from the FileUpload component
            $disk = $fileUploadComponent->getDiskName();
            $directory = $fileUploadComponent->getDirectory();

            // Store the file
            $path = Storage::disk($disk)->putFileAs($directory, $tempPath, $filename);

            // Clean up the temporary file
            unlink($tempPath);

            // Update the FileUpload state
            $livewire = $this->getLivewire();
            $livewire->dispatch('file-upload:finished', [
                'name' => $fieldName,
                'files' => [
                    [
                        'name' => $filename,
                        'size' => Storage::disk($disk)->size($path),
                        'type' => Storage::disk($disk)->mimeType($path),
                        'url' => Storage::disk($disk)->url($path),
                    ],
                ],
            ]);

            return $path;
        } catch (\Exception $e) {
            Log::error('Error generating image with AI: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    protected function getGenerateImageWithAIFormSchema(): array
    {
        return [
            Forms\Components\Textarea::make('prompt')
                ->label('Image Description')
                ->required(),
            Forms\Components\Select::make('size')
                ->label('Image Size')
                ->options([
                    '1024x1024' => '1024x1024',
                    '1024x1792' => '1024x1792',
                    '1792x1024' => '1792x1024',
                ])
                ->default('1024x1024')
                ->required(),
            Forms\Components\Select::make('quality')
                ->label('Image Quality')
                ->options([
                    'standard' => 'Standard',
                    'hd' => 'HD',
                ])
                ->default('standard')
                ->required(),
            Forms\Components\Select::make('style')
                ->label('Image Style')
                ->options([
                    'vivid' => 'Vivid',
                    'natural' => 'Natural',
                ])
                ->default('vivid')
                ->required(),
        ];
    }

    protected function getImageGenerationAction($field, $directory): Action
    {
        return Action::make('generateImage')
            ->label('Generate Image with AI')
            ->action(function (array $data) use ($field, $directory) {
                $generatedImagePath = $this->generateImageWithAI($data, $directory, $field);
                
                if (empty($generatedImagePath)) {
                    Notification::make()
                        ->title('Error')
                        ->body('Failed to generate image. Please try again.')
                        ->danger()
                        ->send();
                    return;
                }
                
                Notification::make()
                    ->title('Success')
                    ->body('Image generated successfully')
                    ->success()
                    ->send();
            })
            ->form($this->getGenerateImageWithAIFormSchema())
            ->modalSubmitActionLabel('Generate Image');
    }
}

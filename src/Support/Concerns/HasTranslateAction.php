<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Stichoza\GoogleTranslate\GoogleTranslate;

trait HasTranslateAction
{
    public function getFieldTranslateActions($field)
    {
        if ($this->activeLocale == 'en') {
            return [];
        }
        $text = $this->getRecord()->getTranslation($field, 'en');
        
        return [
            Action::make('translate')
                ->label('Translate')
                ->color('info')
                ->action(function () use ($text, $field) {
                    if(!empty($text)){
                        try {
                            $translator = new GoogleTranslate();
                            $translatedText = $translator->setSource('en')->setTarget($this->activeLocale)->translate($text);
                            $currentData = $this->getFormFieldsStateByFilled();
                            $currentData[$field] = $translatedText;
                            $this->form->fill($currentData);
                        } catch (\Exception $e) {
                            \Log::error('Translation error: ' . $e->getMessage());
                            \Log::error('Stack trace: ' . $e->getTraceAsString());
                            Notification::make()
                                ->title('Translation Error')
                                ->body('An error occurred while translating the text. Please try again.')
                                ->danger()
                                ->send();
                        }
                    }
                })
        ];
    }

    public function getFormFieldsStateByFilled()
    {
        try {
            $state = [];
            $fields = $this->form->getComponents();
            foreach ($fields as $field) {
                if ($field instanceof Component && $field->hasChildComponentContainer()) {
                    $childFields = $field->getChildComponents();
                    foreach ($childFields as $childField) {
                        if ($childField instanceof Field) {
                            $name = $childField->getName();
                            $value = $childField->getState();
                            if ($value !== null && $value !== '') {
                                $state[$name] = $value;
                            }
                        }
                    }
                } else {
                    $name = $field->getName();
                    $value = $field->getState();
                    if ($value !== null && $value !== '') {
                        $state[$name] = $value;
                    }
                }
            }
            return $state;
        } catch (\Throwable $th) {
            return [];
        }
    }
}

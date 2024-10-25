<?php

namespace Raakkan\OnlyLaravel\Setting;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Str;
use Raakkan\OnlyLaravel\Setting\Models\Setting;

class BaseSettingPage extends Page
{
    use HasUnsavedDataChangesAlert;
    use InteractsWithFormActions;

    protected static string $view = 'only-laravel::filament.pages.base-setting-page';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $slug = 'settings';

    public $data = [];

    public function schema(): array|Closure
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form->schema($this->schema())->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('data')
                ->keyBindings(['mod+s']),
        ];
    }

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $data = Setting::get();

        $this->callHook('beforeFill');

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    public function save(): void
    {
        try {
            $this->callHook('beforeValidate');

            $fields = collect($this->form->getFlatFields(true));
            $fieldsWithNestedFields = $fields->filter(fn (Field $field) => count($field->getChildComponents()) > 0);

            $fieldsWithNestedFields->each(function (Field $fieldWithNestedFields, string $fieldWithNestedFieldsKey) use (&$fields) {
                $fields = $fields->reject(function (Field $field, string $fieldKey) use ($fieldWithNestedFieldsKey) {
                    return Str::startsWith($fieldKey, $fieldWithNestedFieldsKey.'.');
                });
            });

            $data = $fields->mapWithKeys(function (Field $field, string $fieldKey) {
                return [$fieldKey => data_get($this->form->getState(), $fieldKey)];
            })->toArray();

            $this->callHook('afterValidate');

            $this->callHook('beforeSave');

            foreach ($data as $key => $value) {
                Setting::set($key, $value);
            }

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl);
        }
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Settings saved successfully');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }
}

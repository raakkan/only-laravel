<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Raakkan\OnlyLaravel\Models\MenuItemModel;
use Raakkan\OnlyLaravel\Models\MenuModel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MenuItemComponent extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public MenuModel $menu;

    public MenuItemModel $item;

    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill([
            'label' => $this->item->label,
            'url' => $this->item->url,
            'target' => $this->item->target,
        ]);
    }

    public function form(Form $form): Form
    {
        $availableLanguages = ['en', 'ta'];
        $translationFields = [];

        foreach ($availableLanguages as $lang) {
            $translationFields[] = TextInput::make("label_{$lang}")
                ->label("Label ({$lang})")
                ->default($this->item->getTranslation('label', $lang, false))
                ->hintActions($this->getFieldTranslateActions($lang, "label_{$lang}"));
        }

        return $form
            ->schema([
                TextInput::make('label')
                    ->required()
                    ->hintAction(
                        FormAction::make('editTranslations')
                            ->icon('heroicon-m-language')
                            ->label('Edit translations')
                            ->action(function ($data) {
                                foreach ($data as $key => $value) {
                                    if (strpos($key, 'label_') === 0) {
                                        $lang = substr($key, 6);
                                        $this->item->setTranslation('label', $lang, $value);
                                    }
                                }
                                $this->item->save();
                                Notification::make()->success()->title('Translations updated')->send();
                            })
                            ->form(function () use ($translationFields) {
                                return $translationFields;
                            })
                    ),
                TextInput::make('url')->required()->url(),
                TextInput::make('target'),
            ])
            ->statePath('settings')
            ->model($this->item);
    }

    public function save()
    {
        $this->item->update($this->form->getState());
        Notification::make()
            ->title('Menu item saved')
            ->success()
            ->send();
    }

    public function handleDrop(array $data)
    {
        $itemsCount = $this->menu->items()->where('parent_id', $this->item->id)->count();

        $item = $this->menu->items()->create([
            'name' => $data['name'],
            'order' => $itemsCount === 0 ? 0 : $itemsCount++,
            'url' => $data['url'],
            'icon' => $data['icon'],
            'label' => $data['label'],
            'parent_id' => $this->item->id,
        ]);

        Notification::make()
            ->title('Menu item created')
            ->success()
            ->send();
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->icon('heroicon-o-trash')
            ->iconButton()
            ->color('danger')
            ->action(function (Component $livewire) {
                $order = $this->item->order;
                $parentId = $this->item->parent_id;

                $this->item->delete();

                $livewire->dispatch('item-deleted');

                MenuItemModel::reorderSiblings($this->menu, $order, $parentId);

                Notification::make()
                    ->title('Item deleted')
                    ->success()
                    ->send();
            });
    }

    public function render()
    {
        return view('only-laravel::menu.livewire.menu-item-component');
    }

    public function getFieldTranslateActions($lang, $field)
    {
        if ($lang == 'en') {
            return [];
        }

        return [
            FormAction::make('translate')
                ->label('Translate')
                ->action(function ($data) use ($lang, $field) {
                    $text = $this->item->getTranslation('label', 'en', false);
                    if (! empty($text)) {
                        try {
                            $translator = new GoogleTranslate;
                            $translatedText = $translator->setSource('en')->setTarget($lang)->translate($text);
                            $this->mountedFormComponentActionsData[0][$field] = $translatedText;
                            $this->item->setTranslation('label', $lang, $translatedText);
                            $this->item->save();
                        } catch (\Exception $e) {
                            \Log::error('Translation error: '.$e->getMessage());
                            \Log::error('Stack trace: '.$e->getTraceAsString());
                            Notification::make()
                                ->title('Translation Error')
                                ->body('An error occurred while translating the text. Please try again.')
                                ->danger()
                                ->send();
                        }
                    }
                }),
        ];
    }
}

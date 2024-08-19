<?php

namespace Raakkan\OnlyLaravel\Filament\Pages\Page;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->action(function (?Model $record) {
                if (PageManager::pageIsDeletable($record->name)) {
                    Notification::make()
                    ->title('This page cannot be deleted you can disable.')
                    ->warning()
                    ->send();
                    return;
                }

                $result = $this->process(static fn (Model $record) => $record->delete());

                if (! $result) {
                    $this->failure();

                    return;
                }

                $this->success();
            }),
        ];
    }
}
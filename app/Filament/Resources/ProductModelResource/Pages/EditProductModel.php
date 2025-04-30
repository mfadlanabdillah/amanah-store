<?php

namespace App\Filament\Resources\ProductModelResource\Pages;

use App\Filament\Resources\ProductModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductModel extends EditRecord
{
    protected static string $resource = ProductModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getUpdatedNotificationTitle(): ?string
    {
        return 'Product model updated successfully.';
    }
}

<?php

namespace App\Filament\Resources\ProductModelResource\Pages;

use App\Filament\Resources\ProductModelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductModel extends CreateRecord
{
    protected static string $resource = ProductModelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product model created successfully.';
    }
}

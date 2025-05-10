<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

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
        return 'Order updated successfully.';
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->action(fn () => $this->save())
                ->extraAttributes(['class' => 'w-full'])
                ->label('Simpan Perubahan Data')
                ->requiresConfirmation()
                ->color('success')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Cek Kembali')
                ->modalHeading('Simpan Perubahan Data?')
                ->modalDescription('Pastikan semua data sudah benar sebelum menyimpan.')
                ->icon('heroicon-s-check'),
        ];
    }

}

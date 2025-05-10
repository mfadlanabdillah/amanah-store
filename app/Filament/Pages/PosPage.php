<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PosPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-calculator';

    protected static ?string $navigationLabel = 'Point of Sale';

    protected static ?string $slug = 'pos';

    protected static string $view = 'filament.pages.pos-page';
    protected ?string $heading = 'Point of Sale';

    protected static ?int $navigationSort = 105;
}

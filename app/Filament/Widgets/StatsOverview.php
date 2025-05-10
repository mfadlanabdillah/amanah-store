<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Order;
use App\Models\Expense;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $product_count = Product::count();
        $order_count = Order::count();
        $omzet = Order::sum('total_price');
        $expense = Expense::sum('amount');

        // PostgreSQL version for date calculation
        $omzetChart = Order::selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM(total_price) as total')
            ->whereRaw('created_at >= NOW() - INTERVAL \'7 months\'')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();

        $expenseChart = Expense::selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM(amount) as total')
            ->whereRaw('created_at >= NOW() - INTERVAL \'7 months\'')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();

        return [
            Stat::make('Produk', $product_count)
                ->description('Produk yang terdaftar di sistem')
                ->descriptionIcon('heroicon-s-archive-box')
                ->color('primary'),
            Stat::make('Order', $order_count)
                ->description('Order yang terdaftar di sistem')
                ->descriptionIcon('heroicon-s-shopping-cart')
                ->color('success'),
            Stat::make('Omzet', 'Rp'.number_format($omzet,0,",","."))
                ->description('Omzet yang terdaftar di sistem')
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                ->chart($omzetChart)
                ->color('success'),
            Stat::make('Expense', 'Rp'.number_format($expense,0,",","."))
                ->description('Pengeluaran yang terdaftar di sistem')
                ->descriptionIcon('heroicon-s-arrow-trending-down')
                ->chart($expenseChart)
                ->color('danger'),
        ];
    }
}

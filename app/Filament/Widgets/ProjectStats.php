<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Products', Product::count()),

            Stat::make('Categories', ProductCategory::count())
                ->color('info'),

            Stat::make('Product Types', ProductType::count())
                ->color('warning'),

            Stat::make('Product Colors', ProductColor::count())
                ->color('success'),
        ];
    }
}

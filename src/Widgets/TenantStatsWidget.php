<?php

namespace MuhammadNawlo\MultitenantPlugin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use MuhammadNawlo\MultitenantPlugin\Models\Plan;
use MuhammadNawlo\MultitenantPlugin\Models\Tenant;

class TenantStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tenants', Tenant::count())
                ->description('All registered tenants')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make('Active Tenants', Tenant::where('is_active', true)->count())
                ->description('Currently active tenants')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Plans', Plan::count())
                ->description('Available subscription plans')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info'),

            Stat::make('Active Plans', Plan::where('is_active', true)->count())
                ->description('Currently active plans')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}

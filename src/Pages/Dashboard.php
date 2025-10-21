<?php

namespace MuhammadNawlo\MultitenantPlugin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use MuhammadNawlo\MultitenantPlugin\Widgets\TenantStatsWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament-panels::pages.dashboard';

    public function getWidgets(): array
    {
        return [
            TenantStatsWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}

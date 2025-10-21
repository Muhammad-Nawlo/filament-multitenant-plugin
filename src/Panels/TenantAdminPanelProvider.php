<?php

namespace MuhammadNawlo\MultitenantPlugin\Panels;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Navigation\NavigationItem;
use MuhammadNawlo\MultitenantPlugin\Resources\TenantResource;
use MuhammadNawlo\MultitenantPlugin\Resources\PlanResource;
use MuhammadNawlo\MultitenantPlugin\Widgets\TenantStatsWidget;
use MuhammadNawlo\MultitenantPlugin\Pages\Dashboard;

class TenantAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('tenant-admin')
            ->path('tenant-admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->resources([
                TenantResource::class,
                PlanResource::class,
            ])
            ->navigationItems([
                NavigationItem::make('Tenants')
                    ->url(fn (): string => TenantResource::getUrl('index'))
                    ->icon('heroicon-o-building-office')
                    ->activeIcon('heroicon-s-building-office')
                    ->sort(1),
                NavigationItem::make('Plans')
                    ->url(fn (): string => PlanResource::getUrl('index'))
                    ->icon('heroicon-o-credit-card')
                    ->activeIcon('heroicon-s-credit-card')
                    ->sort(2),
            ])
            ->brandName('Tenant Management')
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.png'))
            ->colors([
                'primary' => '#3B82F6',
            ])
            ->discoverResources(
                in: __DIR__ . '/../Resources',
                for: 'MuhammadNawlo\\MultitenantPlugin\\Resources'
            )
            ->pages([
                Dashboard::class,
            ])
            ->discoverPages(
                in: __DIR__ . '/../Pages',
                for: 'MuhammadNawlo\\MultitenantPlugin\\Pages'
            )
            ->widgets([
                TenantStatsWidget::class,
            ])
            ->discoverWidgets(
                in: __DIR__ . '/../Widgets',
                for: 'MuhammadNawlo\\MultitenantPlugin\\Widgets'
            )
            ->middleware([
                'web',
                'auth',
            ])
            ->authMiddleware([
                'auth',
            ]);
    }
}
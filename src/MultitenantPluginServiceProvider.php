<?php

namespace MuhammadNawlo\MultitenantPlugin;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MuhammadNawlo\MultitenantPlugin\Commands\MultitenantPluginCommand;
use MuhammadNawlo\MultitenantPlugin\Testing\TestsMultitenantPlugin;
use MuhammadNawlo\MultitenantPlugin\Panels\TenantAdminPanelProvider;
use Stancl\Tenancy\TenancyServiceProvider;
use BezhanSalleh\FilamentShield\FilamentShieldServiceProvider;

class MultitenantPluginServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-multitenant-plugin';

    public static string $viewNamespace = 'filament-multitenant-plugin';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('muhammad-nawlo/filament-multitenant-plugin');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void 
    {
        // Register required service providers
        $this->app->register(TenancyServiceProvider::class);
        $this->app->register(FilamentShieldServiceProvider::class);
        
        // Register the tenant admin panel
        $this->app->register(TenantAdminPanelProvider::class);
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-multitenant-plugin/{$file->getFilename()}"),
                ], 'filament-multitenant-plugin-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsMultitenantPlugin);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'muhammad-nawlo/filament-multitenant-plugin';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-multitenant-plugin', __DIR__ . '/../resources/dist/components/filament-multitenant-plugin.js'),
            Css::make('filament-multitenant-plugin-styles', __DIR__ . '/../resources/dist/filament-multitenant-plugin.css'),
            Js::make('filament-multitenant-plugin-scripts', __DIR__ . '/../resources/dist/filament-multitenant-plugin.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            MultitenantPluginCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_plans_table',
            'create_plan_roles_table',
        ];
    }
}

<?php

namespace MuhammadNawlo\MultitenantPlugin\Commands;

use Illuminate\Console\Command;
use MuhammadNawlo\MultitenantPlugin\Database\Seeders\DefaultPlansSeeder;

class MultitenantPluginCommand extends Command
{
    public $signature = 'multitenancy:setup {--seed : Run the default plans seeder}';

    public $description = 'Setup the multitenancy plugin with default configuration';

    public function handle(): int
    {
        $this->info('Setting up Filament Multitenancy Manager...');

        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'filament-multitenant-plugin-migrations',
            '--force' => true,
        ]);

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'filament-multitenant-plugin-config',
            '--force' => true,
        ]);

        // Run migrations
        $this->call('migrate');

        if ($this->option('seed')) {
            $this->info('Seeding default plans...');
            $this->call('db:seed', [
                '--class' => DefaultPlansSeeder::class,
            ]);
        }

        $this->info('✅ Multitenancy plugin setup complete!');
        $this->line('');
        $this->line('Next steps:');
        $this->line('1. Configure your tenancy settings in config/tenancy.php');
        $this->line('2. Set up Filament Shield in your application');
        $this->line('3. Visit /tenant-admin to access the admin panel');

        if (! $this->option('seed')) {
            $this->line('4. Run "php artisan multitenancy:setup --seed" to create default plans');
        }

        return self::SUCCESS;
    }
}

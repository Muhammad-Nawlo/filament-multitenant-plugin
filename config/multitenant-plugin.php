<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Multitenancy Manager Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the Multitenancy Manager
    | plugin. You can customize various aspects of the plugin behavior here.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Panel Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the default settings for the tenant admin panel.
    |
    */
    'panel' => [
        'id' => 'tenant-admin',
        'path' => 'tenant-admin',
        'brand_name' => 'Tenant Management',
        'brand_logo' => null,
        'favicon' => null,
        'colors' => [
            'primary' => '#3B82F6',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant Configuration
    |--------------------------------------------------------------------------
    |
    | Configure tenant-specific settings and behavior.
    |
    */
    'tenant' => [
        'model' => \MuhammadNawlo\MultitenantPlugin\Models\Tenant::class,
        'domain_model' => \Stancl\Tenancy\Database\Models\Domain::class,
        'database_prefix' => 'tenant_',
        'auto_create_database' => true,
        'auto_assign_roles' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plan Configuration
    |--------------------------------------------------------------------------
    |
    | Configure subscription plan settings and features.
    |
    */
    'plan' => [
        'model' => \MuhammadNawlo\MultitenantPlugin\Models\Plan::class,
        'default_currency' => 'USD',
        'auto_assign_roles' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Shield Integration
    |--------------------------------------------------------------------------
    |
    | Configure Filament Shield integration settings.
    |
    */
    'shield' => [
        'enabled' => true,
        'super_admin_role' => 'super_admin',
        'default_roles' => [
            'super_admin',
            'admin',
            'manager',
            'editor',
            'user',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Configure database settings for tenant management.
    |
    */
    'database' => [
        'tenant_connection' => 'tenant',
        'central_connection' => 'mysql',
        'migration_path' => database_path('migrations/tenant'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Features Configuration
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific features of the plugin.
    |
    */
    'features' => [
        'tenant_creation' => true,
        'plan_management' => true,
        'role_assignment' => true,
        'domain_management' => true,
        'database_management' => true,
        'tenant_switching' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Configure security settings for the plugin.
    |
    */
    'security' => [
        'require_authentication' => true,
        'allowed_domains' => [],
        'blocked_domains' => [],
        'max_tenants_per_user' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    |
    | Configure notification settings for tenant events.
    |
    */
    'notifications' => [
        'tenant_created' => true,
        'tenant_updated' => true,
        'tenant_deleted' => true,
        'plan_changed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching settings for better performance.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
        'prefix' => 'multitenancy_manager',
    ],
];

# Filament Multitenancy Manager

A comprehensive Filament 3 plugin for managing multitenancy with `stancl/tenancy` and `bezhansalleh/filament-shield` integration.

## Features

- 🏢 **Tenant Management**: Create and manage tenants with custom domains
- 📋 **Subscription Plans**: Define plans with role-based access control
- 🔐 **Role Integration**: Seamless integration with Filament Shield
- 🎯 **Central Admin Panel**: Dedicated panel for tenant administration
- 🗄️ **Database Management**: Automatic tenant database creation
- 🚀 **Easy Setup**: Simple installation and configuration

## Installation

You can install the package via composer:

```bash
composer require muhammad-nawlo/filament-multitenant-plugin
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="filament-multitenant-plugin-migrations"
php artisan migrate
```

Publish the config file:

```bash
php artisan vendor:publish --tag="filament-multitenant-plugin-config"
```

## Configuration

### 1. Service Provider Registration

Add the service provider to your `config/app.php`:

```php
'providers' => [
    // ...
    MuhammadNawlo\MultitenantPlugin\MultitenantPluginServiceProvider::class,
],
```

### 2. Tenancy Configuration

Configure `stancl/tenancy` in your `config/tenancy.php`:

```php
return [
    'tenant_model' => \MuhammadNawlo\MultitenantPlugin\Models\Tenant::class,
    'domain_model' => \Stancl\Tenancy\Database\Models\Domain::class,
    // ... other tenancy settings
];
```

### 3. Shield Configuration

Ensure `bezhansalleh/filament-shield` is properly configured in your application.

## Usage

### Accessing the Admin Panel

Visit `/tenant-admin` to access the tenant management panel.

### Creating Tenants

1. Navigate to the Tenants section
2. Click "Create Tenant"
3. Fill in tenant details:
   - **ID**: Unique identifier
   - **Name**: Display name
   - **Domain**: Primary domain (e.g., `tenant.example.com`)
   - **Database**: Database name
   - **Plan**: Select a subscription plan

### Managing Plans

1. Navigate to the Plans section
2. Create or edit subscription plans
3. Assign roles to each plan
4. Define plan features and pricing

### Default Plans

The plugin includes a seeder with default plans:

- **Free**: Basic features with user role
- **Starter**: Advanced features with user and editor roles
- **Professional**: Full features with user, editor, and manager roles
- **Enterprise**: Complete access with all roles

Run the seeder:

```bash
php artisan db:seed --class="MuhammadNawlo\MultitenantPlugin\Database\Seeders\DefaultPlansSeeder"
```

## Architecture

### Models

- **Tenant**: Extends `stancl/tenancy` tenant model with plan relationships
- **Plan**: Subscription plans with role assignments
- **Role**: Filament Shield roles linked to plans

### Resources

- **TenantResource**: Full CRUD for tenant management
- **PlanResource**: Subscription plan management with role assignments

### Panel

- **TenantAdminPanel**: Central domain panel for tenant administration

## Configuration Options

The plugin provides extensive configuration options in `config/multitenancy-manager.php`:

```php
return [
    'panel' => [
        'id' => 'tenant-admin',
        'path' => 'tenant-admin',
        'brand_name' => 'Tenant Management',
    ],
    'tenant' => [
        'auto_create_database' => true,
        'auto_assign_roles' => true,
    ],
    'features' => [
        'tenant_creation' => true,
        'plan_management' => true,
        'role_assignment' => true,
    ],
];
```

## Security

- Authentication required for all admin operations
- Role-based access control via Filament Shield
- Domain validation and security checks
- Configurable tenant limits and restrictions

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Muhammad-Nawlo](https://github.com/Muhammad-Nawlo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
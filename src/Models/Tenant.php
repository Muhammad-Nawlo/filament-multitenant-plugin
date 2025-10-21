<?php

namespace MuhammadNawlo\MultitenantPlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasDatabase;
    use HasDomains;

    protected $fillable = [
        'id',
        'name',
        'domain',
        'database',
        'plan_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the plan that owns the tenant.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the users for the tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(config('auth.providers.users.model'));
    }

    /**
     * Get the tenant's domain.
     */
    public function getDomainAttribute(): string
    {
        return $this->domains()->first()?->domain ?? '';
    }

    /**
     * Set the tenant's domain.
     */
    public function setDomainAttribute(string $domain): void
    {
        $this->domains()->updateOrCreate(
            ['domain' => $domain],
            ['domain' => $domain]
        );
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            // Auto-generate database name if not provided
            if (empty($tenant->database)) {
                $tenant->database = 'tenant_' . $tenant->id;
            }
        });

        static::created(function ($tenant) {
            // Create tenant database
            $tenant->createDatabase();

            // Assign plan roles to tenant
            if ($tenant->plan) {
                $tenant->assignPlanRoles();
            }
        });
    }

    /**
     * Create the tenant database.
     */
    public function createDatabase(): void
    {
        // This will be handled by stancl/tenancy
        // The actual database creation logic is in the tenancy configuration
    }

    /**
     * Assign roles from the plan to the tenant.
     */
    public function assignPlanRoles(): void
    {
        if (! $this->plan) {
            return;
        }

        // Get roles associated with the plan
        $roles = $this->plan->roles;

        // Store roles in tenant data for later use
        $this->update([
            'data' => array_merge($this->data ?? [], [
                'roles' => $roles->pluck('name')->toArray(),
            ]),
        ]);
    }
}

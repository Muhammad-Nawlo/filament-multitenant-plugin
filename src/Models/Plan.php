<?php

namespace MuhammadNawlo\MultitenantPlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',
        'features',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the tenants for the plan.
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get the roles for the plan.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'plan_roles');
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the plan's formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Check if the plan has a specific feature.
     */
    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    /**
     * Add a feature to the plan.
     */
    public function addFeature(string $feature): void
    {
        $features = $this->features ?? [];
        if (! in_array($feature, $features)) {
            $features[] = $feature;
            $this->update(['features' => $features]);
        }
    }

    /**
     * Remove a feature from the plan.
     */
    public function removeFeature(string $feature): void
    {
        $features = $this->features ?? [];
        $features = array_filter($features, fn ($f) => $f !== $feature);
        $this->update(['features' => array_values($features)]);
    }
}

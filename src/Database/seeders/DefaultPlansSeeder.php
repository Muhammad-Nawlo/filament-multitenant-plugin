<?php

namespace MuhammadNawlo\MultitenantPlugin\Database\Seeders;

use Illuminate\Database\Seeder;
use MuhammadNawlo\MultitenantPlugin\Models\Plan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default roles
        $roles = $this->createDefaultRoles();
        
        // Create default plans
        $this->createDefaultPlans($roles);
    }

    /**
     * Create default roles for the system.
     */
    private function createDefaultRoles(): array
    {
        $roles = [];

        // Super Admin role
        $roles['super_admin'] = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        // Admin role
        $roles['admin'] = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // Manager role
        $roles['manager'] = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        // User role
        $roles['user'] = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // Editor role
        $roles['editor'] = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web',
        ]);

        return $roles;
    }

    /**
     * Create default subscription plans.
     */
    private function createDefaultPlans(array $roles): void
    {
        // Free Plan
        $freePlan = Plan::firstOrCreate([
            'name' => 'Free',
        ], [
            'description' => 'Basic plan with limited features',
            'price' => 0.00,
            'is_active' => true,
            'features' => [
                'Basic dashboard access',
                'Limited user management',
                'Basic reporting',
            ],
        ]);

        // Assign user role to free plan
        $freePlan->roles()->sync([$roles['user']->id]);

        // Starter Plan
        $starterPlan = Plan::firstOrCreate([
            'name' => 'Starter',
        ], [
            'description' => 'Perfect for small teams getting started',
            'price' => 29.99,
            'is_active' => true,
            'features' => [
                'Advanced dashboard',
                'User management',
                'Basic reporting',
                'Email support',
                'API access',
            ],
        ]);

        // Assign user and editor roles to starter plan
        $starterPlan->roles()->sync([
            $roles['user']->id,
            $roles['editor']->id,
        ]);

        // Professional Plan
        $professionalPlan = Plan::firstOrCreate([
            'name' => 'Professional',
        ], [
            'description' => 'Advanced features for growing businesses',
            'price' => 79.99,
            'is_active' => true,
            'features' => [
                'All Starter features',
                'Advanced analytics',
                'Team management',
                'Priority support',
                'Custom integrations',
                'Advanced reporting',
            ],
        ]);

        // Assign user, editor, and manager roles to professional plan
        $professionalPlan->roles()->sync([
            $roles['user']->id,
            $roles['editor']->id,
            $roles['manager']->id,
        ]);

        // Enterprise Plan
        $enterprisePlan = Plan::firstOrCreate([
            'name' => 'Enterprise',
        ], [
            'description' => 'Full-featured solution for large organizations',
            'price' => 199.99,
            'is_active' => true,
            'features' => [
                'All Professional features',
                'Unlimited users',
                'Advanced security',
                'Dedicated support',
                'Custom development',
                'White-label options',
                'Advanced analytics',
                'Compliance tools',
            ],
        ]);

        // Assign all roles to enterprise plan
        $enterprisePlan->roles()->sync([
            $roles['user']->id,
            $roles['editor']->id,
            $roles['manager']->id,
            $roles['admin']->id,
        ]);

        // Custom Plan (for demonstration)
        $customPlan = Plan::firstOrCreate([
            'name' => 'Custom',
        ], [
            'description' => 'Tailored solution for specific needs',
            'price' => 0.00, // Custom pricing
            'is_active' => true,
            'features' => [
                'Fully customizable',
                'Dedicated account manager',
                'Custom development',
                'Flexible pricing',
            ],
        ]);

        // Assign admin role to custom plan
        $customPlan->roles()->sync([$roles['admin']->id]);
    }
}

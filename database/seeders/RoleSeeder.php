<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

// The three Scrum roles. Held per-project via project_user. See ADR-0004.
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['slug' => 'product_owner', 'name' => 'Product Owner', 'description' => 'Owns and orders the product backlog.'],
            ['slug' => 'scrum_master', 'name' => 'Scrum Master', 'description' => 'Facilitates the process and removes impediments.'],
            ['slug' => 'developer', 'name' => 'Developer', 'description' => 'Builds the increment.'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}

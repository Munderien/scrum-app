<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

// Global default workflow states (project_id = null). Per-project overrides added later. See ADR-0008.
class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'task'   => ['To Do', 'In Progress', 'In Review', 'Done'],
            'pbi'    => ['New', 'Ready', 'In Progress', 'Done'],
            'sprint' => ['Planning', 'Active', 'Completed'],
        ];

        foreach ($defaults as $category => $names) {
            foreach ($names as $order => $name) {
                Status::firstOrCreate(
                    ['category' => $category, 'name' => $name, 'project_id' => null],
                    ['order' => $order],
                );
            }
        }
    }
}

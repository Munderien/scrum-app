<?php

namespace Database\Seeders;

use App\Models\Blocker;
use App\Models\ProductBacklogItem;
use App\Models\Project;
use App\Models\Role;
use App\Models\Sprint;
use App\Models\SprintItem;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── User ──────────────────────────────────────────────────────────
        $user = User::firstOrCreate(
            ['email' => 'munderien@scrumapp.test'],
            [
                'name'     => 'Munderien',
                'password' => Hash::make('password'),
            ]
        );

        $po  = Role::where('slug', 'product_owner')->first();
        $sm  = Role::where('slug', 'scrum_master')->first();
        $dev = Role::where('slug', 'developer')->first();

        // Statuses (fetched dynamically so ULIDs always match the seeded rows)
        $s = fn(string $cat, string $name) => Status::where('category', $cat)
            ->where('name', $name)
            ->whereNull('project_id')
            ->firstOrFail();

        $taskTodo       = $s('task', 'To Do');
        $taskInProgress = $s('task', 'In Progress');
        $taskInReview   = $s('task', 'In Review');
        $taskDone       = $s('task', 'Done');
        $pbiNew         = $s('pbi',  'New');
        $pbiReady       = $s('pbi',  'Ready');
        $pbiInProgress  = $s('pbi',  'In Progress');
        $pbiDone        = $s('pbi',  'Done');
        $sprintPlanning = $s('sprint', 'Planning');
        $sprintActive   = $s('sprint', 'Active');
        $sprintDone     = $s('sprint', 'Completed');

        // ══════════════════════════════════════════════════════════════════
        // PROJECT 1 — Scrum App itself
        // ══════════════════════════════════════════════════════════════════
        $p1 = Project::create([
            'name'       => 'Scrum App',
            'key'        => 'SCRM',
            'description' => 'Building the Scrum project management tool itself.',
            'created_by' => $user->id,
        ]);

        // Munderien is Product Owner on this project
        $p1->members()->attach($user->id, ['role_id' => $po->id]);

        // ── Product Backlog ───────────────────────────────────────────────
        $pbis1 = [
            $p1->backlogItems()->create(['title' => 'User can register and log in',        'type' => 'story', 'status_id' => $pbiDone->id,        'story_points' => 3,  'priority' => 'high',     'position' => 1, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Project CRUD (create / view / edit)', 'type' => 'story', 'status_id' => $pbiInProgress->id,  'story_points' => 5,  'priority' => 'high',     'position' => 2, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Product backlog management',          'type' => 'story', 'status_id' => $pbiReady->id,       'story_points' => 8,  'priority' => 'high',     'position' => 3, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Sprint planning board',               'type' => 'story', 'status_id' => $pbiReady->id,       'story_points' => 13, 'priority' => 'high',     'position' => 4, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Drag-and-drop backlog ordering',      'type' => 'story', 'status_id' => $pbiNew->id,         'story_points' => 5,  'priority' => 'medium',   'position' => 5, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Blocker / impediment tracking',       'type' => 'story', 'status_id' => $pbiNew->id,         'story_points' => 5,  'priority' => 'medium',   'position' => 6, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Fix: session expires on login form',  'type' => 'bug',   'status_id' => $pbiReady->id,       'story_points' => 2,  'priority' => 'critical', 'position' => 7, 'created_by' => $user->id]),
            $p1->backlogItems()->create(['title' => 'Epic: reporting & velocity charts',   'type' => 'epic',  'status_id' => $pbiNew->id,         'story_points' => null, 'priority' => 'low',   'position' => 8, 'created_by' => $user->id]),
        ];

        // ── Sprint 1 (completed) ──────────────────────────────────────────
        $sp1 = Sprint::create([
            'project_id' => $p1->id,
            'status_id'  => $sprintDone->id,
            'name'       => 'Sprint 1 — Auth & foundation',
            'goal'       => 'Users can register, log in, and land on a dashboard.',
            'starts_at'  => '2026-06-01',
            'ends_at'    => '2026-06-14',
            'created_by' => $user->id,
        ]);

        // Commit PBI 0 (auth story — done) into sprint 1
        $si1_0 = SprintItem::create([
            'sprint_id'               => $sp1->id,
            'product_backlog_item_id' => $pbis1[0]->id,
            'status_id'               => $pbiDone->id,
            'committed_points'        => 3,
            'position'                => 1,
            'created_by'              => $user->id,
        ]);

        $t = Task::create(['sprint_item_id' => $si1_0->id, 'status_id' => $taskDone->id, 'title' => 'Install Breeze scaffolding',       'estimate_hours' => 1, 'created_by' => $user->id]);
        $t->assignees()->attach($user->id);
        $t = Task::create(['sprint_item_id' => $si1_0->id, 'status_id' => $taskDone->id, 'title' => 'Configure MySQL connection',       'estimate_hours' => 0.5, 'created_by' => $user->id]);
        $t->assignees()->attach($user->id);
        $t = Task::create(['sprint_item_id' => $si1_0->id, 'status_id' => $taskDone->id, 'title' => 'Verify login/register flow',       'estimate_hours' => 1, 'created_by' => $user->id]);
        $t->assignees()->attach($user->id);

        // ── Sprint 2 (active) ─────────────────────────────────────────────
        $sp2 = Sprint::create([
            'project_id' => $p1->id,
            'status_id'  => $sprintActive->id,
            'name'       => 'Sprint 2 — Projects & backlog',
            'goal'       => 'Users can create projects and manage a product backlog.',
            'starts_at'  => '2026-06-15',
            'ends_at'    => '2026-06-28',
            'created_by' => $user->id,
        ]);

        // PBI 1 — project CRUD (in progress)
        $si2_1 = SprintItem::create([
            'sprint_id'               => $sp2->id,
            'product_backlog_item_id' => $pbis1[1]->id,
            'status_id'               => $pbiInProgress->id,
            'committed_points'        => 5,
            'position'                => 1,
            'created_by'              => $user->id,
        ]);

        $tCreate = Task::create(['sprint_item_id' => $si2_1->id, 'status_id' => $taskDone->id,       'title' => 'ProjectController index + store',    'estimate_hours' => 2,   'created_by' => $user->id]);
        $tCreate->assignees()->attach($user->id);
        Task::create(['sprint_item_id' => $si2_1->id, 'parent_id' => $tCreate->id, 'status_id' => $taskDone->id, 'title' => 'Write store() validation', 'estimate_hours' => 0.5, 'created_by' => $user->id]);

        $tEdit = Task::create(['sprint_item_id' => $si2_1->id, 'status_id' => $taskInProgress->id,  'title' => 'ProjectController edit + update',    'estimate_hours' => 2,   'created_by' => $user->id]);
        $tEdit->assignees()->attach($user->id);
        Task::create(['sprint_item_id' => $si2_1->id, 'parent_id' => $tEdit->id, 'status_id' => $taskTodo->id, 'title' => 'Write update() validation', 'estimate_hours' => 0.5, 'created_by' => $user->id]);
        Task::create(['sprint_item_id' => $si2_1->id, 'parent_id' => $tEdit->id, 'status_id' => $taskTodo->id, 'title' => 'Add project-not-found 404 handling', 'estimate_hours' => 0.5, 'created_by' => $user->id]);

        $tDelete = Task::create(['sprint_item_id' => $si2_1->id, 'status_id' => $taskTodo->id, 'title' => 'ProjectController destroy (soft delete)', 'estimate_hours' => 1, 'created_by' => $user->id]);
        $tDelete->assignees()->attach($user->id);

        // Blocker on the edit task
        $tEdit->blockers()->create([
            'title'      => 'Waiting for project-key uniqueness decision',
            'description' => 'Unsure if project keys should be globally unique or scoped to the user. Blocks validation logic.',
            'raised_by'  => $user->id,
            'created_by' => $user->id,
        ]);

        // PBI 6 — session bug (also in this sprint — critical)
        $si2_bug = SprintItem::create([
            'sprint_id'               => $sp2->id,
            'product_backlog_item_id' => $pbis1[6]->id,
            'status_id'               => $pbiInProgress->id,
            'committed_points'        => 2,
            'position'                => 2,
            'created_by'              => $user->id,
        ]);

        $tBug = Task::create(['sprint_item_id' => $si2_bug->id, 'status_id' => $taskInReview->id, 'title' => 'Reproduce session-expiry on login form', 'estimate_hours' => 1, 'created_by' => $user->id]);
        $tBug->assignees()->attach($user->id);
        Task::create(['sprint_item_id' => $si2_bug->id, 'status_id' => $taskTodo->id, 'title' => 'Apply fix + add regression test', 'estimate_hours' => 1, 'created_by' => $user->id]);

        // ── Sprint 3 (planning) ───────────────────────────────────────────
        $sp3 = Sprint::create([
            'project_id' => $p1->id,
            'status_id'  => $sprintPlanning->id,
            'name'       => 'Sprint 3 — Sprint board & backlog ordering',
            'goal'       => 'Teams can plan sprints and re-order the backlog.',
            'starts_at'  => '2026-06-29',
            'ends_at'    => '2026-07-12',
            'created_by' => $user->id,
        ]);

        SprintItem::create([
            'sprint_id'               => $sp3->id,
            'product_backlog_item_id' => $pbis1[2]->id,
            'committed_points'        => 8,
            'position'                => 1,
            'created_by'              => $user->id,
        ]);
        SprintItem::create([
            'sprint_id'               => $sp3->id,
            'product_backlog_item_id' => $pbis1[3]->id,
            'committed_points'        => 13,
            'position'                => 2,
            'created_by'              => $user->id,
        ]);

        // Blocker on the sprint itself
        $sp3->blockers()->create([
            'title'      => 'Design mockups not yet approved',
            'description' => 'Sprint board UI direction still pending stakeholder sign-off. Blocks frontend tasks.',
            'raised_by'  => $user->id,
            'created_by' => $user->id,
        ]);

        // ══════════════════════════════════════════════════════════════════
        // PROJECT 2 — Side project: personal finance tracker
        // ══════════════════════════════════════════════════════════════════
        $p2 = Project::create([
            'name'        => 'Finance Tracker',
            'key'         => 'FIN',
            'description' => 'A simple personal income/expense tracker.',
            'created_by'  => $user->id,
        ]);

        // Munderien is Scrum Master on this one
        $p2->members()->attach($user->id, ['role_id' => $sm->id]);

        $p2pbis = [
            $p2->backlogItems()->create(['title' => 'Log income and expenses',          'type' => 'story', 'status_id' => $pbiReady->id, 'story_points' => 5, 'priority' => 'high',   'position' => 1, 'created_by' => $user->id]),
            $p2->backlogItems()->create(['title' => 'Monthly summary dashboard',        'type' => 'story', 'status_id' => $pbiNew->id,   'story_points' => 8, 'priority' => 'medium', 'position' => 2, 'created_by' => $user->id]),
            $p2->backlogItems()->create(['title' => 'Export transactions to CSV',       'type' => 'story', 'status_id' => $pbiNew->id,   'story_points' => 3, 'priority' => 'low',    'position' => 3, 'created_by' => $user->id]),
            $p2->backlogItems()->create(['title' => 'Spike: evaluate chart libraries',  'type' => 'spike', 'status_id' => $pbiNew->id,   'story_points' => 2, 'priority' => 'medium', 'position' => 4, 'created_by' => $user->id]),
        ];

        $sp4 = Sprint::create([
            'project_id' => $p2->id,
            'status_id'  => $sprintActive->id,
            'name'       => 'Sprint 1 — Core transaction logging',
            'goal'       => 'Users can log income and expenses.',
            'starts_at'  => '2026-06-10',
            'ends_at'    => '2026-06-24',
            'created_by' => $user->id,
        ]);

        $si4_0 = SprintItem::create([
            'sprint_id'               => $sp4->id,
            'product_backlog_item_id' => $p2pbis[0]->id,
            'status_id'               => $pbiInProgress->id,
            'committed_points'        => 5,
            'position'                => 1,
            'created_by'              => $user->id,
        ]);

        $tModel = Task::create(['sprint_item_id' => $si4_0->id, 'status_id' => $taskDone->id,       'title' => 'Create Transaction model + migration', 'estimate_hours' => 1.5, 'created_by' => $user->id]);
        $tModel->assignees()->attach($user->id);

        $tForm = Task::create(['sprint_item_id' => $si4_0->id, 'status_id' => $taskInProgress->id, 'title' => 'Build income/expense entry form',      'estimate_hours' => 3,   'created_by' => $user->id]);
        $tForm->assignees()->attach($user->id);
        Task::create(['sprint_item_id' => $si4_0->id, 'parent_id' => $tForm->id, 'status_id' => $taskTodo->id, 'title' => 'Add amount + category validation', 'estimate_hours' => 0.5, 'created_by' => $user->id]);
        Task::create(['sprint_item_id' => $si4_0->id, 'parent_id' => $tForm->id, 'status_id' => $taskTodo->id, 'title' => 'Add date picker component',         'estimate_hours' => 1,   'created_by' => $user->id]);

        Task::create(['sprint_item_id' => $si4_0->id, 'status_id' => $taskTodo->id, 'title' => 'Transaction list view with filters', 'estimate_hours' => 2, 'created_by' => $user->id]);
    }
}

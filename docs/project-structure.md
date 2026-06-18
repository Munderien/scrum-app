# Project Structure Overview

Foundation of a Scrum project management system — **Laravel 13 + MySQL**.
Structure, database, and models only. No business logic, no domain frontend yet
(Breeze auth views are the only UI).

## Layering

```
HTTP Request
   │
   ▼
Controller (app/Http/Controllers)   thin — delegates to a Service
   │
   ▼
Service    (app/Services)           use-case orchestration (empty stubs for now)
   │
   ▼
Repository (app/Repositories)       data access behind an interface
   │
   ▼
Model      (app/Models)             Eloquent entities — relationships only
   │
   ▼
MySQL                               migrations in database/migrations
```

See [ADR-0012](adr/0012-service-repository-layering.md). Contracts are bound to
Eloquent implementations in
[`RepositoryServiceProvider`](../app/Providers/RepositoryServiceProvider.php),
registered in `bootstrap/providers.php`.

## Directory map

```
app/
├── Http/Controllers/
│   ├── ProjectController.php              ProductBacklogItemController.php
│   ├── SprintController.php   TaskController.php   BlockerController.php
│   └── Auth/ , ProfileController.php      (Breeze)
├── Models/
│   ├── User.php          (Breeze + relations)   Role.php       Project.php
│   ├── Membership.php    (project_user pivot)    Status.php
│   ├── ProductBacklogItem.php   Sprint.php       SprintItem.php
│   ├── Task.php          Blocker.php
├── Services/
│   ├── ProjectService.php   ProductBacklogItemService.php
│   ├── SprintService.php    TaskService.php       BlockerService.php
├── Repositories/
│   ├── Contracts/        *RepositoryInterface.php  (5)
│   └── Eloquent/         BaseRepository.php + Eloquent*Repository.php (5)
└── Providers/
    └── RepositoryServiceProvider.php

database/
├── migrations/   3 default + 10 domain (2026_06_18_1000xx_*)
└── seeders/      RoleSeeder.php  StatusSeeder.php  DatabaseSeeder.php

docs/
├── glossary.md            ubiquitous language
├── project-structure.md   this file
└── adr/                   12 Architecture Decision Records
```

## Data model

```
User ─┬─< project_user (Membership: role_id) >─┬─ Project ──< Status (category, nullable project_id)
      │                                         ├──< ProductBacklogItem ─┐
      └─< task_user >── Task                    └──< Sprint ──< SprintItem ┘  (sprint_items = sprint↔PBI pivot)
                          │                                    │
                          ├─ parent_id ─> Task (subtasks)      └──< Task ──< Task (subtasks)
                          │
   Blocker >──(morphTo blockable)── Task | ProductBacklogItem | Sprint
```

Key points (each backed by an ADR):
- **Roles** are per-project, carried on the `project_user` pivot via `role_id`. — [0004](adr/0004-per-project-roles.md)
- **`sprint_items`** is the Sprint Backlog: a pivot (sprint ↔ PBI) modelled as a first-class entity that owns Tasks. — [0005](adr/0005-sprint-items-pivot.md)
- **Tasks** attach to a `sprint_item` and self-reference via `parent_id` for subtasks (no separate `subtasks` table). — [0006](adr/0006-self-referencing-tasks.md)
- **Blockers** are polymorphic over Task / PBI / Sprint with a raised→resolved lifecycle. — [0007](adr/0007-polymorphic-blockers.md)
- **Statuses** are one unified, project-scoped lookup table (`category` + nullable `project_id`). — [0008](adr/0008-unified-status-lookup.md)
- **Keys**: ULID everywhere except `users` (BigInt, from Breeze); user FKs are BigInt. — [0003](adr/0003-ulid-primary-keys.md)
- **Soft deletes + `created_by`** on the domain tables. — [0010](adr/0010-soft-deletes-audit.md)
- **Ordering**: both `position` (manual rank) and `priority` (enum). — [0011](adr/0011-position-and-priority.md)

## Tables

| Table | Purpose | PK |
|-------|---------|----|
| `users` | accounts (Breeze) | BigInt |
| `roles` | Scrum roles lookup | ULID |
| `projects` | top-level container | ULID |
| `project_user` | membership + per-project role | ULID |
| `statuses` | workflow states (task/pbi/sprint), global or per-project | ULID |
| `product_backlog_items` | the product backlog | ULID |
| `sprints` | iterations | ULID |
| `sprint_items` | sprint backlog (sprint↔PBI commitment) | ULID |
| `tasks` | work + subtasks (self-ref) | ULID |
| `task_user` | task assignees | composite |
| `blockers` | polymorphic impediments | ULID |

## Setup / verification

```bash
# 1. Configure DB in .env (already set): DB_CONNECTION=mysql, DB_DATABASE=scrum_app
# 2. Create the database (WAMP/phpMyAdmin) named `scrum_app`
# 3. Migrate + seed defaults (3 roles, 11 statuses)
php artisan migrate:fresh --seed

# 4. Run
php artisan serve        # + npm run dev  (for Breeze assets)
```

This foundation was migrated and seeded against MySQL, and all Eloquent
relationships were smoke-tested end-to-end before delivery.

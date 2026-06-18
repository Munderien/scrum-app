# Architecture Decision Records

Each ADR captures one decision made during the design grilling, why it was made,
and what it costs. Format: Context → Decision → Consequences.

| # | Decision | Status |
|---|----------|--------|
| [0001](0001-mysql-database.md) | Use MySQL as the database | Accepted |
| [0002](0002-laravel-breeze-auth.md) | Laravel Breeze for authentication scaffolding | Accepted |
| [0003](0003-ulid-primary-keys.md) | ULID primary keys on all domain tables | Accepted |
| [0004](0004-per-project-roles.md) | Roles are per-project via the `project_user` pivot | Accepted |
| [0005](0005-sprint-items-pivot.md) | Sprint Backlog is a pivot (`sprint_items`) between sprints and PBIs | Accepted |
| [0006](0006-self-referencing-tasks.md) | Single self-referencing `tasks` table; no separate `subtasks` table | Accepted |
| [0007](0007-polymorphic-blockers.md) | Blockers are polymorphic lifecycle entities | Accepted |
| [0008](0008-unified-status-lookup.md) | Statuses live in one project-scoped lookup table | Accepted |
| [0009](0009-estimation-fields.md) | Story points + PBI type + task estimate hours | Accepted |
| [0010](0010-soft-deletes-audit.md) | Soft deletes and `created_by` audit on domain tables | Accepted |
| [0011](0011-position-and-priority.md) | Both `position` and `priority` for backlog ordering | Accepted |
| [0012](0012-service-repository-layering.md) | Service + Repository layering | Accepted |

# 0008 — Statuses live in one project-scoped lookup table

**Status:** Accepted

## Context
Statuses (task: todo/in_progress/done; PBI; sprint: planning/active/completed) can
be hard-coded enums or data-driven lookup rows. The team wants workflows that can be
customized per project later.

## Decision
A single **`statuses`** table with: `category` (enum: `task` | `pbi` | `sprint`),
`name`, `order`, and a **nullable `project_id`**. A null `project_id` is a global
default status; a set `project_id` is a project-specific override.

`tasks`, `product_backlog_items`, and `sprints` each reference it via a
`status_id` FK instead of carrying a status enum.

## Consequences
- Workflows are data-driven and customizable per project without a schema change.
- A seeder must provide the global default statuses per category (seeding is part of
  setup, but workflow *transition rules* are business logic — out of scope now).
- More joins than enum columns; acceptable for the flexibility gained.
- `Status` model: `belongsTo Project` (nullable); each consuming model `belongsTo
  Status`.
- `category` keeps task/pbi/sprint statuses in one table while preventing a sprint
  from accidentally using a task status (enforced in logic later).

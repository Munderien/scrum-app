# 0010 — Soft deletes and `created_by` audit on domain tables

**Status:** Accepted

## Context
A PM tool benefits from recoverable deletes and knowing who created records. Options
ranged from timestamps-only to soft deletes plus authorship.

## Decision
Add **`deleted_at`** (`SoftDeletes` trait) and a **`created_by`** user FK to the
domain tables: `projects`, `product_backlog_items`, `sprints`, `sprint_items`,
`tasks`, `blockers`. Lookup tables (`roles`, `statuses`) and pivots keep plain
timestamps only.

## Consequences
- Deleted records are recoverable and attributable to a creator.
- `created_by` is `unsignedBigInteger` referencing `users` (BigInt, ADR-0003).
- Models using soft deletes add the `SoftDeletes` trait and cast `deleted_at`.
- Cascade/restore behavior and "who deleted" tracking are business logic — not
  implemented now. `created_by` is a nullable column at the schema level so seeding
  and system-created rows don't break.

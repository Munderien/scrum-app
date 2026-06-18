# 0003 — ULID primary keys on all domain tables

**Status:** Accepted

## Context
Choice of primary key strategy: BigInt auto-increment (Laravel default), UUID, or
ULID. Sequential IDs are guessable and leak row counts; UUIDs are random and hurt
index locality.

## Decision
Use **ULID** (`HasUlids` trait, `CHAR(26)` columns) as the primary key for all
domain tables: `projects`, `roles`, `product_backlog_items`, `sprints`,
`sprint_items`, `tasks`, `blockers`, `statuses`.

## Consequences
- IDs are non-guessable and URL-friendly, yet **lexicographically sortable by
  creation time**, preserving good index locality (unlike UUIDv4).
- All foreign keys and the polymorphic `blockable` columns are `CHAR(26)`. We use
  explicit `foreignUlid()` / `char(..., 26)` rather than `foreignId()`.
- `users` keeps Breeze's default BigInt id (changing it would fight the auth
  scaffolding); FKs that reference users (`created_by`, `assignee`, `raised_by`,
  `resolved_by`, `project_user.user_id`) are therefore `unsignedBigInteger`.
- This is the one place the key strategy is intentionally mixed — documented so it
  is not mistaken for an inconsistency.

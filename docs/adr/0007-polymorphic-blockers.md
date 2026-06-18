# 0007 — Blockers are polymorphic lifecycle entities

**Status:** Accepted

## Context
Impediments can affect different things — a task, a whole PBI, or an entire sprint.
A blocker also has a lifecycle (raised, then resolved) rather than being a boolean
flag.

## Decision
A `blockers` table with a **polymorphic `blockable`** relation (`blockable_id`
CHAR(26) + `blockable_type`) that can point at a Task, ProductBacklogItem, or
Sprint. Lifecycle fields: `description`, `raised_by`, `resolved_at`,
`resolved_by`.

## Consequences
- One impediment model serves all three blockable types via `morphTo`.
- Each blockable model gets a `morphMany` `blockers()` relation.
- "Is it blocked / for how long" is derivable from `resolved_at` (null = open) —
  but that computation is business logic and **not implemented yet**.
- Polymorphic key columns are `CHAR(26)` to match ULID parents (ADR-0003), so we
  define the morph columns explicitly rather than using `morphs()` (which assumes
  BigInt).
- `raised_by` / `resolved_by` reference `users` (BigInt FK).

# 0006 — Single self-referencing `tasks` table; no separate `subtasks` table

**Status:** Accepted

## Context
The brief listed `tasks` and `subtasks` as separate tables. A subtask is
structurally identical to a task. Two tables duplicate columns, cap nesting at two
levels, and double the relationship wiring.

## Decision
Use **one `tasks` table** with a nullable self-referencing `parent_id`. A subtask is
simply a task whose `parent_id` is set. Tasks belong to a `sprint_item`.

## Consequences
- Replaces the planned `subtasks` table — this is the one deviation from the brief's
  table list, made deliberately.
- `Task parent()` / `Task children()` (a.k.a. `subtasks()`) self-relations.
- Nesting depth is not constrained by the schema (enforce a max in business logic
  later if desired).
- Tasks live under the sprint_item, so a task exists only in the context of a
  committed sprint item — matching the Scrum notion that tasks are the sprint's
  breakdown of work.
- Many assignees per task via `task_user` (see ADR-0011/glossary), plus a
  `created_by` reporter.

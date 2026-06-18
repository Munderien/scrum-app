# 0011 — Both `position` and `priority` for backlog ordering

**Status:** Accepted

## Context
Scrum backlogs are ranked. Manual fine-grained ordering (drag-and-drop) and a coarse
priority classification serve different needs; the team wants both so the user can
filter/sort to their liking.

## Decision
- `product_backlog_items.position` — integer manual rank within the project backlog.
- `product_backlog_items.priority` — enum `low` | `medium` | `high` | `critical`.
- `sprint_items.position` — integer manual rank within the sprint.

## Consequences
- Users can sort by hand (position) **or** filter/group by priority class.
- Uniqueness/compaction of `position` values is **business logic — not enforced**
  here (the column simply exists, indexed for ordering).
- `priority` default is `medium`.
- Tasks rely on status + parent grouping for now; a task-level position can be added
  later if board ordering within a column is needed.

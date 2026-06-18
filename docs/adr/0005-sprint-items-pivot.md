# 0005 — Sprint Backlog is a pivot (`sprint_items`) between sprints and PBIs

**Status:** Accepted

## Context
How does a Product Backlog Item enter a Sprint? Options: a `sprint_items` pivot
(sprint ↔ PBI), a nullable `sprint_id` on the PBI, or frozen snapshot copies.

## Decision
`sprint_items` is a **pivot table** linking one `sprint` to one
`product_backlog_item`, carrying sprint-local fields: `committed_points`,
`position` (rank within the sprint), and its own status. The PBI row remains the
single source of truth for the item.

## Consequences
- The Product Backlog (all PBIs of a project) and the Sprint Backlog (the
  `sprint_items` of a sprint) are clearly distinct without duplicating item data.
- A PBI can be planned into a sprint and still keep its product-level estimate and
  priority.
- **Tasks attach to the `sprint_item`, not the PBI** (see ADR-0006) — work is the
  effort to deliver that item *in that sprint*.
- `sprint_items` is modelled as a first-class Eloquent model (`SprintItem`), not an
  anonymous pivot, because it owns child rows (tasks) and its own fields.
- Snapshot/copy approach rejected: avoids data duplication and drift.

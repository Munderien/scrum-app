# 0009 — Story points + PBI type + task estimate hours

**Status:** Accepted

## Context
Estimation granularity for the foundation: nothing, points only, points + type, or
points + type + task hours.

## Decision
- `product_backlog_items.story_points` — `decimal(5,1)` nullable (supports fib/half
  points).
- `product_backlog_items.type` — enum `story` | `bug` | `epic` | `spike`.
- `tasks.estimate_hours` — `decimal(5,2)` nullable.

## Consequences
- Supports standard Scrum estimation (relative points at the backlog level,
  hours at the task level).
- `type` lets the backlog distinguish stories from bugs/epics/spikes for filtering
  and reporting later.
- Velocity, burndown, and rollups are **derived business logic — not implemented**;
  only the fields to compute them exist.
- `decimal` (not integer) chosen so half-points and fractional hours are possible
  without a later migration.

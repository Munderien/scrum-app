# 0004 — Roles are per-project via the `project_user` pivot

**Status:** Accepted

## Context
The brief listed both a `roles` table and a `project_user` pivot. In Scrum a person
can be Product Owner on one project and a Developer on another, so a single global
role per user is wrong. Options: per-project pivot role, Spatie laravel-permission,
global role on user, or a bare enum.

## Decision
Keep a `roles` lookup table (Product Owner, Scrum Master, Developer) and attach the
role to the **membership**: `project_user` carries a `role_id`. A user's role is
therefore scoped to a single project.

## Consequences
- Correctly models the real Scrum constraint (role varies per project).
- `User belongsToMany Project withPivot(role_id)`; `Project belongsToMany User`.
- A dedicated `Membership` pivot model exposes the role relation cleanly.
- Spatie was rejected for the foundation: heavier dependency and granular
  permissions are not needed yet. A future move to Spatie (team-scoped) remains
  possible without reshaping the domain tables.
- Authorization logic is **out of scope** now (no policies/gates yet) — only the
  structure to support it.

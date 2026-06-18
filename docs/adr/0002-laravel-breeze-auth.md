# 0002 — Laravel Breeze for authentication scaffolding

**Status:** Accepted

## Context
The brief asks for "simple login/register". Options weighed: Breeze (minimal
Blade auth), Fortify (headless backend only), Jetstream (teams + 2FA), and
hand-rolled controllers.

## Decision
Use **Laravel Breeze** (Blade stack) for login, registration, password reset,
and email verification scaffolding.

## Consequences
- Matches "simple" exactly; readable controllers and views we can extend.
- Jetstream was rejected: its built-in **Teams** concept overlaps and conflicts
  with our own Project/Membership/Role model (ADR-0004), which would cause
  confusion and duplicate authorization paths.
- Fortify/hand-rolled were rejected as either too bare or too much boilerplate
  for a foundation phase.
- Breeze publishes its own `users` migration; our domain migrations build on top
  of it rather than replacing it.

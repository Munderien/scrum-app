# 0012 — Service + Repository layering

**Status:** Accepted

## Context
The brief asks for Models, Controllers, Services, and (preferred) Repositories,
with **no business logic yet**. We want a structure that keeps controllers thin and
keeps persistence concerns isolated, ready to fill in later.

## Decision
Adopt a four-layer structure:

```
Controller  →  Service  →  Repository  →  Model (Eloquent)
```

- **Controllers** (`app/Http/Controllers`): HTTP only; delegate to services.
- **Services** (`app/Services`): use-case/business orchestration. Created as empty
  classes now.
- **Repositories** (`app/Repositories`): data access behind an interface, bound in a
  service provider. Created as interface + Eloquent implementation stubs now.
- **Models** (`app/Models`): Eloquent entities — relationships only at this stage.

## Consequences
- Clear seams for adding logic later without reshaping the app.
- A `RepositoryServiceProvider` binds each interface to its Eloquent implementation.
- Slight upfront boilerplate (interface + impl per aggregate) — accepted as the brief
  prefers repositories.
- **No methods are implemented** in services/repositories yet; they are intentionally
  empty scaffolding per "no business logic yet".

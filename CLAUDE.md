# CLAUDE.md — Scrum App

Codebase context for Claude Code. Keep this file up to date as the project evolves.

---

## Project

A **Scrum-style project management system** built with **Laravel 13 + MySQL**.
Developer: **Munderien** (GitHub: `Munderien`).

Current phase: **foundation only** — structure, database, models, auth.
No business logic and no domain frontend yet.

---

## Stack

| Layer | Tech |
|-------|------|
| Backend | Laravel 13 (PHP 8.3) |
| Database | MySQL via WAMP / phpMyAdmin |
| Auth | Laravel Breeze (Blade) |
| Frontend build | Vite 8 + Tailwind CSS 3 + Alpine.js |
| Package manager | Composer 2 + npm |
| Keys | ULID on all domain tables; `users` keeps BigInt (Breeze) |

---

## Dev setup

```bash
# 1. Copy .env.example → .env and set your app key
php artisan key:generate

# 2. Create the database (WAMP/phpMyAdmin) named: scrum_app
#    .env is already configured: DB_CONNECTION=mysql, DB_DATABASE=scrum_app

# 3. Migrate + seed (roles, statuses, Munderien test data)
php artisan migrate:fresh --seed

# 4. Start dev servers
php artisan serve      # http://localhost:8000
npm run dev            # http://localhost:5173 (HMR)
```

Both servers are registered in `.claude/launch.json` — Claude Code can start them
with `preview_start`.

### Test login
| Field | Value |
|-------|-------|
| Email | `munderien@scrumapp.test` |
| Password | `password` |

---

## Branching strategy

```
master          — production-ready (main protected branch)
  └─ dev        — integration branch; feature branches merge here
       └─ feat/<name>   — one branch per feature
```

- All feature branches cut from `dev`.
- PRs always target `dev`, never `master` directly.
- `dev` → `master` for releases.

---

## Architecture

```
Controller → Service → Repository (interface) → Model (Eloquent) → MySQL
```

- **Controllers** — HTTP only, delegate to services (`app/Http/Controllers/`)
- **Services** — use-case orchestration, empty stubs for now (`app/Services/`)
- **Repositories** — data access behind interfaces (`app/Repositories/`)
  - Contracts in `Contracts/`, Eloquent implementations in `Eloquent/`
  - Bound in `RepositoryServiceProvider` → `bootstrap/providers.php`
- **Models** — relationships only, no business logic (`app/Models/`)

---

## Domain model (key tables)

| Table | Purpose | PK |
|-------|---------|----|
| `users` | Breeze auth accounts | BigInt |
| `roles` | Scrum roles lookup (PO, SM, Dev) | ULID |
| `projects` | Top-level container | ULID |
| `project_user` | Membership + per-project role | ULID |
| `statuses` | Workflow states for task/pbi/sprint — global or project-scoped | ULID |
| `product_backlog_items` | The product backlog | ULID |
| `sprints` | Iterations | ULID |
| `sprint_items` | Sprint Backlog (sprint ↔ PBI pivot, first-class model) | ULID |
| `tasks` | Work items; self-referencing `parent_id` for subtasks | ULID |
| `task_user` | Task assignees (many-to-many) | composite |
| `blockers` | Polymorphic impediments (Task / PBI / Sprint) | ULID |

### Key design decisions (each has a full ADR in `docs/adr/`)
- Roles are **per-project** via `project_user.role_id` — not global on the user.
- `sprint_items` is a **first-class pivot model** (not anonymous); tasks attach to it, not to PBIs.
- **No separate `subtasks` table** — one `tasks` table with nullable `parent_id`.
- Blockers are **polymorphic** (`blockable_type` / `blockable_id`) with a raised→resolved lifecycle.
- Statuses are **data-driven** (one `statuses` table, `category` enum, nullable `project_id` for overrides).
- Domain tables have **soft deletes + `created_by`** audit columns.
- Ordering: both `position` (manual rank) and `priority` (low/medium/high/critical) on PBIs.

---

## Seeders

| Seeder | What it creates |
|--------|----------------|
| `RoleSeeder` | 3 Scrum roles: Product Owner, Scrum Master, Developer |
| `StatusSeeder` | 11 global default statuses (4 task, 4 pbi, 3 sprint) |
| `TestDataSeeder` | Munderien user + 2 projects + 4 sprints + 12 PBIs + 16 tasks + 2 blockers |

---

## Docs

| File | Purpose |
|------|---------|
| `docs/glossary.md` | Ubiquitous language — use these terms everywhere |
| `docs/project-structure.md` | Layering, directory map, ER overview |
| `docs/adr/README.md` | Index of all 12 Architecture Decision Records |
| `graphify-out/graph.html` | Interactive knowledge graph (open in browser) |
| `graphify-out/obsidian/` | Obsidian vault — open as vault in Obsidian |

---

## What's NOT here yet (next phases)

- Business logic in Services / Repositories
- Domain frontend (Blade views for projects, backlog, sprints, tasks)
- Authorization (policies / gates per project role)
- API layer
- Velocity / burndown reporting
- Per-project status workflow customization

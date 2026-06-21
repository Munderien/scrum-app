# Graph Report - .  (2026-06-21)

## Corpus Check
- Corpus is ~35,058 words - fits in a single context window. You may not need a graph.

## Summary
- 546 nodes · 661 edges · 108 communities (107 shown, 1 thin omitted)
- Extraction: 98% EXTRACTED · 2% INFERRED · 0% AMBIGUOUS · INFERRED: 15 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Auth HTTP Layer|Auth HTTP Layer]]
- [[_COMMUNITY_Eloquent Relationships|Eloquent Relationships]]
- [[_COMMUNITY_Repository & Service Layer|Repository & Service Layer]]
- [[_COMMUNITY_Composer Dependencies|Composer Dependencies]]
- [[_COMMUNITY_Auth Feature Tests|Auth Feature Tests]]
- [[_COMMUNITY_Architecture Decisions (ADRs)|Architecture Decisions (ADRs)]]
- [[_COMMUNITY_Frontend Dependencies|Frontend Dependencies]]
- [[_COMMUNITY_Task Model|Task Model]]
- [[_COMMUNITY_Sprint Model|Sprint Model]]
- [[_COMMUNITY_User Model|User Model]]
- [[_COMMUNITY_Login Request & Rate Limiting|Login Request & Rate Limiting]]
- [[_COMMUNITY_Database Seeders|Database Seeders]]
- [[_COMMUNITY_Session Controller|Session Controller]]
- [[_COMMUNITY_Status Model|Status Model]]
- [[_COMMUNITY_Blade Layout Components|Blade Layout Components]]
- [[_COMMUNITY_Password Reset Flow|Password Reset Flow]]
- [[_COMMUNITY_User Registration Flow|User Registration Flow]]
- [[_COMMUNITY_Email Verification Flow|Email Verification Flow]]
- [[_COMMUNITY_User Factory|User Factory]]
- [[_COMMUNITY_Profile Views|Profile Views]]
- [[_COMMUNITY_Misc (layouts_app_blade)|Misc (layouts_app_blade)]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 25 edges
2. `TestCase` - 20 edges
3. `Ubiquitous Language Glossary` - 14 edges
4. `Architecture Decision Records Index` - 12 edges
5. `Task` - 11 edges
6. `ProductBacklogItem` - 10 edges
7. `Project` - 10 edges
8. `Sprint` - 10 edges
9. `Project Structure Overview` - 10 edges
10. `SprintItem` - 9 edges

## Surprising Connections (you probably didn't know these)
- `Laravel Framework` --conceptually_related_to--> `MySQL`  [INFERRED]
  README.md → docs/adr/0001-mysql-database.md
- `Laravel Framework` --conceptually_related_to--> `Laravel Breeze`  [INFERRED]
  README.md → docs/adr/0002-laravel-breeze-auth.md
- `Role (domain concept)` --conceptually_related_to--> `Per-Project Roles Decision`  [INFERRED]
  docs/glossary.md → docs/adr/0004-per-project-roles.md
- `sprint_items Pivot Table` --semantically_similar_to--> `project_user Pivot (Membership)`  [INFERRED] [semantically similar]
  docs/adr/0005-sprint-items-pivot.md → docs/adr/0004-per-project-roles.md
- `AuthenticatedSessionController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Auth/AuthenticatedSessionController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Core Scrum Domain Model (Project, Sprint, PBI, Task)** — glossary_project, glossary_sprint, glossary_pbi, glossary_task, glossary_sprint_item [INFERRED 0.95]
- **Data Integrity ADR Cluster (ULID, Soft Deletes, Audit)** — adr_0003_ulid_concept, adr_0010_soft_deletes_concept, adr_0001_mysql_db [INFERRED 0.85]
- **Backlog Ordering Pattern (Position, Priority, Sprint Items)** — adr_0011_position_priority_concept, adr_0005_sprint_items_concept, glossary_product_backlog [INFERRED 0.80]

## Communities (108 total, 1 thin omitted)

### Community 0 - "Auth HTTP Layer"
Cohesion: 0.05
Nodes (28): RedirectResponse, Request, View, RedirectResponse, Request, RedirectResponse, Request, View (+20 more)

### Community 1 - "Eloquent Relationships"
Cohesion: 0.07
Nodes (23): BelongsTo, BelongsTo, BelongsTo, BelongsToMany, HasMany, MorphMany, BelongsTo, BelongsToMany (+15 more)

### Community 2 - "Repository & Service Layer"
Cohesion: 0.05
Nodes (25): Blocker, BlockerRepositoryInterface, BaseRepository, EloquentBlockerRepository, EloquentProductBacklogItemRepository, EloquentProjectRepository, EloquentSprintRepository, EloquentTaskRepository (+17 more)

### Community 3 - "Composer Dependencies"
Cohesion: 0.04
Nodes (48): pestphp/pest-plugin, php-http/discovery, autoload, autoload-dev, psr-4, psr-4, config, allow-plugins (+40 more)

### Community 4 - "Auth Feature Tests"
Cohesion: 0.06
Nodes (12): AuthenticationTest, EmailVerificationTest, PasswordConfirmationTest, PasswordResetTest, PasswordUpdateTest, RegistrationTest, BaseTestCase, ExampleTest (+4 more)

### Community 5 - "Architecture Decisions (ADRs)"
Cohesion: 0.08
Nodes (41): MySQL Database Decision, MySQL, Laravel Breeze Auth Decision, Laravel Breeze, ULID Primary Keys Decision, ULID Primary Keys, project_user Pivot (Membership), Per-Project Roles Decision (+33 more)

### Community 6 - "Frontend Dependencies"
Cohesion: 0.12
Nodes (16): devDependencies, alpinejs, autoprefixer, concurrently, laravel-vite-plugin, postcss, tailwindcss, @tailwindcss/forms (+8 more)

### Community 7 - "Task Model"
Cohesion: 0.24
Nodes (5): BelongsTo, BelongsToMany, HasMany, MorphMany, Task

### Community 8 - "Sprint Model"
Cohesion: 0.26
Nodes (5): BelongsTo, BelongsToMany, HasMany, MorphMany, Sprint

### Community 9 - "User Model"
Cohesion: 0.27
Nodes (6): BelongsToMany, HasMany, Authenticatable, HasFactory, User, Notifiable

### Community 10 - "Login Request & Rate Limiting"
Cohesion: 0.27
Nodes (3): LoginRequest, FormRequest, ProfileUpdateRequest

### Community 11 - "Database Seeders"
Cohesion: 0.25
Nodes (5): Seeder, DatabaseSeeder, RoleSeeder, StatusSeeder, WithoutModelEvents

### Community 12 - "Session Controller"
Cohesion: 0.36
Nodes (5): RedirectResponse, Request, View, AuthenticatedSessionController, LoginRequest

### Community 13 - "Status Model"
Cohesion: 0.36
Nodes (3): BelongsTo, HasMany, Status

### Community 14 - "Blade Layout Components"
Cohesion: 0.33
Nodes (5): View, View, Component, AppLayout, GuestLayout

### Community 15 - "Password Reset Flow"
Cohesion: 0.43
Nodes (4): RedirectResponse, Request, View, PasswordResetLinkController

### Community 16 - "User Registration Flow"
Cohesion: 0.43
Nodes (4): RedirectResponse, Request, View, RegisteredUserController

### Community 17 - "Email Verification Flow"
Cohesion: 0.53
Nodes (4): RedirectResponse, Request, View, EmailVerificationPromptController

### Community 18 - "User Factory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 19 - "Profile Views"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

## Knowledge Gaps
- **67 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+62 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **1 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Auth HTTP Layer` to `User Registration Flow`, `Email Verification Flow`, `Session Controller`, `Password Reset Flow`?**
  _High betweenness centrality (0.021) - this node is a cross-community bridge._
- **Why does `Task` connect `Task Model` to `Eloquent Relationships`?**
  _High betweenness centrality (0.021) - this node is a cross-community bridge._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _67 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Auth HTTP Layer` be split into smaller, more focused modules?**
  _Cohesion score 0.052525252525252523 - nodes in this community are weakly interconnected._
- **Should `Eloquent Relationships` be split into smaller, more focused modules?**
  _Cohesion score 0.07058001397624039 - nodes in this community are weakly interconnected._
- **Should `Repository & Service Layer` be split into smaller, more focused modules?**
  _Cohesion score 0.054426705370101594 - nodes in this community are weakly interconnected._
- **Should `Composer Dependencies` be split into smaller, more focused modules?**
  _Cohesion score 0.04081632653061224 - nodes in this community are weakly interconnected._
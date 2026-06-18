# Glossary — Ubiquitous Language

The shared vocabulary for this Scrum project management system. Code, tables,
and conversation should all use these terms with these meanings.

| Term | Meaning in this system | Backing table / model |
|------|------------------------|-----------------------|
| **User** | A person with an account. Authenticates via Breeze. Belongs to zero or more Projects. | `users` / `User` |
| **Project** | The top-level container for a product effort. Owns one backlog, many sprints, and a team of users. (We use "Project" rather than "Product"; one Project == one Product Backlog.) | `projects` / `Project` |
| **Membership** | The link between a User and a Project, carrying the user's Role on that Project. A user may hold different roles on different projects. | `project_user` pivot |
| **Role** | A Scrum role a member holds *within a project*: Product Owner, Scrum Master, or Developer. | `roles` / `Role` |
| **Product Backlog** | The ordered list of all desired work for a Project. Not a table itself — it is the set of `product_backlog_items` belonging to a Project, ranked by `position`/`priority`. | (view over `product_backlog_items`) |
| **Product Backlog Item (PBI)** | A single desired piece of work: a story, bug, epic, or spike. Has story points, a type, a status, a position, and a priority. Lives at the Project level across sprints. | `product_backlog_items` / `ProductBacklogItem` |
| **Sprint** | A time-boxed iteration within a Project, with a goal, start/end dates, and a status. | `sprints` / `Sprint` |
| **Sprint Backlog** | The set of PBIs committed to a specific Sprint — i.e. the `sprint_items` for that Sprint. | (view over `sprint_items`) |
| **Sprint Item** | The commitment of one PBI into one Sprint. The pivot that also carries sprint-local fields (committed points, position). Tasks hang off Sprint Items, not PBIs. | `sprint_items` / `SprintItem` |
| **Task** | A unit of work to complete a Sprint Item within a sprint. May have child tasks (subtasks) via `parent_id`. Assignable to multiple users. | `tasks` / `Task` |
| **Subtask** | A Task whose `parent_id` points at another Task. Not a separate table — same model, self-referencing. | `tasks` (self-ref) |
| **Assignee** | A User assigned to work a Task. A Task may have many. | `task_user` pivot |
| **Blocker / Impediment** | Anything stopping progress. A polymorphic record that can block a Task, a PBI, or a Sprint. Has a lifecycle: raised → resolved. | `blockers` / `Blocker` |
| **Status** | A workflow state for a Task, PBI, or Sprint. Stored in a unified lookup table, optionally scoped to a Project for custom workflows. | `statuses` / `Status` |
| **Story Points** | Relative effort estimate on a PBI. | `product_backlog_items.story_points` |
| **Estimate Hours** | Time estimate on a Task. | `tasks.estimate_hours` |
| **Position** | Integer manual rank used to order backlog items / sprint items (drag-and-drop). | `*.position` |
| **Priority** | Coarse classification enum (low/medium/high/critical) on a PBI, independent of position. | `product_backlog_items.priority` |

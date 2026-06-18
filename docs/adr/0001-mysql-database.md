# 0001 — Use MySQL as the database

**Status:** Accepted

## Context
The system runs on a local WAMP stack with phpMyAdmin. The team is already
operating MySQL and wants migrations to target it.

## Decision
Use **MySQL** as the primary datastore. Configure the connection in `.env`
(`DB_CONNECTION=mysql`, default port 3306, database `scrum_app`). All migrations
are written to MySQL-compatible column types.

## Consequences
- Works directly with the existing WAMP / phpMyAdmin tooling.
- ULID keys are stored as `CHAR(26)` (see ADR-0003).
- Polymorphic and FK columns use `CHAR(26)` to match ULID parents rather than
  the default `unsignedBigInteger` morph helper — noted where relevant.
- No DB-engine-specific features (e.g. Postgres JSONB, partial indexes) are used,
  keeping a future migration to another engine cheap.

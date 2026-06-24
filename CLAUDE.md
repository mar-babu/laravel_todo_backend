# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repo.

## Project

Todo App Backend is a REST API for task management. 

Stack: Laravel 12 + PHP 8+, MySQL, Laravel Sanctum for API authentication.

## Common Commands

```bash
php artisan serve          # Run local development server
php artisan test           # Run PHPUnit tests
php artisan migrate        # Run database migrations
php artisan route:list     # View API routes
```

## Architecture

### API Structure
- **Routes**: Defined in `routes/api.php`. All core endpoints (tasks, logout) are protected by `auth:sanctum` middleware.
- **Controllers**: Thin controllers mapping requests to services (`app/Http/Controllers/TaskController.php`, `app/Http/Controllers/Api/AuthController.php`).
- **Services**: Business logic is handled in `app/Services/` (e.g., `TaskService.php`).
- **Data Models**: Eloquent models located in `app/Models/` (e.g., `Task.php`, `User.php`).
- **Enums**: Constants and discrete states defined in `app/Enums/` (e.g., `TaskStatus.php`).
- **Validation**: Form requests for validation logic `app/Http/Requests/` (e.g., `StoreTaskRequest`, `UpdateTaskRequest`).
- **Resources**: API payload structures defined in `app/Http/Resources/` (e.g., `TaskResource.php`).

### Status Enum Mapping
- Tasks have four statuses mapped via the `TaskStatus` enum: `PENDING` (0), `IN_PROGRESS` (1), `COMPLETED` (2), `CANCELLED` (3). Update the enum and database default if new statuses are required.

## Conventions

### PHP
- Use explicit return types and parameter types everywhere.
- Prefer constructor property promotion.
- Avoid deep nested `if/else` statements. Use early returns.

### Laravel-specific
- Use API Resources (`TaskResource`) to format model output. Do not return raw models from controllers.
- Use FormRequests (`StoreTaskRequest`) instead of `$request->validate()` in controllers.
- `TaskService` handles database operations. Avoid direct `Task::create()` or `Task::where()` calls in `TaskController`.
- Tokens are issued via Sanctum (`$user->createToken()`). During login, prior tokens are deleted (`$user->tokens()->delete()`) to enforce a single active session or reset.

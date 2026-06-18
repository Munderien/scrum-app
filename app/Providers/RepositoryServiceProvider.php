<?php

namespace App\Providers;

use App\Repositories\Contracts\BlockerRepositoryInterface;
use App\Repositories\Contracts\ProductBacklogItemRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\SprintRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Eloquent\EloquentBlockerRepository;
use App\Repositories\Eloquent\EloquentProductBacklogItemRepository;
use App\Repositories\Eloquent\EloquentProjectRepository;
use App\Repositories\Eloquent\EloquentSprintRepository;
use App\Repositories\Eloquent\EloquentTaskRepository;
use Illuminate\Support\ServiceProvider;

// Binds repository contracts to their Eloquent implementations. See ADR-0012.
class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    public array $bindings = [
        ProjectRepositoryInterface::class => EloquentProjectRepository::class,
        ProductBacklogItemRepositoryInterface::class => EloquentProductBacklogItemRepository::class,
        SprintRepositoryInterface::class => EloquentSprintRepository::class,
        TaskRepositoryInterface::class => EloquentTaskRepository::class,
        BlockerRepositoryInterface::class => EloquentBlockerRepository::class,
    ];
}

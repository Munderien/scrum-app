<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Shared base for Eloquent repositories. Holds the model the repository wraps.
 * Query/persistence methods are added per repository as business logic lands.
 */
abstract class BaseRepository
{
    public function __construct(protected Model $model)
    {
    }
}

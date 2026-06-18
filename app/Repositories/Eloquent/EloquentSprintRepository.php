<?php

namespace App\Repositories\Eloquent;

use App\Models\Sprint;
use App\Repositories\Contracts\SprintRepositoryInterface;

class EloquentSprintRepository extends BaseRepository implements SprintRepositoryInterface
{
    public function __construct(Sprint $model)
    {
        parent::__construct($model);
    }
}

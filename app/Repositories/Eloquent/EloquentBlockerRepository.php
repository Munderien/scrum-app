<?php

namespace App\Repositories\Eloquent;

use App\Models\Blocker;
use App\Repositories\Contracts\BlockerRepositoryInterface;

class EloquentBlockerRepository extends BaseRepository implements BlockerRepositoryInterface
{
    public function __construct(Blocker $model)
    {
        parent::__construct($model);
    }
}

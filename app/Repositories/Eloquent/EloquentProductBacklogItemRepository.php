<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductBacklogItem;
use App\Repositories\Contracts\ProductBacklogItemRepositoryInterface;

class EloquentProductBacklogItemRepository extends BaseRepository implements ProductBacklogItemRepositoryInterface
{
    public function __construct(ProductBacklogItem $model)
    {
        parent::__construct($model);
    }
}

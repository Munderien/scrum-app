<?php

namespace App\Services;

use App\Repositories\Contracts\ProductBacklogItemRepositoryInterface;

/** Use-case orchestration for the product backlog. Business logic added later (ADR-0012). */
class ProductBacklogItemService
{
    public function __construct(private ProductBacklogItemRepositoryInterface $backlogItems)
    {
    }
}

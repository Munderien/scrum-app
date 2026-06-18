<?php

namespace App\Http\Controllers;

use App\Services\ProductBacklogItemService;

/** HTTP entrypoint for the product backlog. Actions added later (ADR-0012). */
class ProductBacklogItemController extends Controller
{
    public function __construct(private ProductBacklogItemService $backlogItems)
    {
    }
}

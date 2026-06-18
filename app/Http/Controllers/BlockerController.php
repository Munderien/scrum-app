<?php

namespace App\Http\Controllers;

use App\Services\BlockerService;

/** HTTP entrypoint for blockers. Actions added later (ADR-0012). */
class BlockerController extends Controller
{
    public function __construct(private BlockerService $blockers)
    {
    }
}

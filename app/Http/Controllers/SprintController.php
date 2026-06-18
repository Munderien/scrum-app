<?php

namespace App\Http\Controllers;

use App\Services\SprintService;

/** HTTP entrypoint for sprints. Actions added later (ADR-0012). */
class SprintController extends Controller
{
    public function __construct(private SprintService $sprints)
    {
    }
}

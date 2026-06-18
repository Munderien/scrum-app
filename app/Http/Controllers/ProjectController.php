<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;

/** HTTP entrypoint for projects. Actions added later (ADR-0012). */
class ProjectController extends Controller
{
    public function __construct(private ProjectService $projects)
    {
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\TaskService;

/** HTTP entrypoint for tasks. Actions added later (ADR-0012). */
class TaskController extends Controller
{
    public function __construct(private TaskService $tasks)
    {
    }
}

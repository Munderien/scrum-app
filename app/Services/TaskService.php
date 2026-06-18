<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;

/** Use-case orchestration for tasks. Business logic added later (ADR-0012). */
class TaskService
{
    public function __construct(private TaskRepositoryInterface $tasks)
    {
    }
}

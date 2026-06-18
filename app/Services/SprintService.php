<?php

namespace App\Services;

use App\Repositories\Contracts\SprintRepositoryInterface;

/** Use-case orchestration for sprints. Business logic added later (ADR-0012). */
class SprintService
{
    public function __construct(private SprintRepositoryInterface $sprints)
    {
    }
}

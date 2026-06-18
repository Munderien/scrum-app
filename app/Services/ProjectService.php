<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;

/** Use-case orchestration for projects. Business logic added later (ADR-0012). */
class ProjectService
{
    public function __construct(private ProjectRepositoryInterface $projects)
    {
    }
}

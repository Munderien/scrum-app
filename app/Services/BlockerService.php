<?php

namespace App\Services;

use App\Repositories\Contracts\BlockerRepositoryInterface;

/** Use-case orchestration for blockers. Business logic added later (ADR-0012). */
class BlockerService
{
    public function __construct(private BlockerRepositoryInterface $blockers)
    {
    }
}

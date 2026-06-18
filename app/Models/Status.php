<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Unified workflow state for tasks/PBIs/sprints. category disambiguates. See ADR-0008.
class Status extends Model
{
    use HasUlids;

    protected $guarded = [];

    /** Owning project, or null for a global default status. */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function backlogItems(): HasMany
    {
        return $this->hasMany(ProductBacklogItem::class);
    }

    public function sprints(): HasMany
    {
        return $this->hasMany(Sprint::class);
    }

    public function sprintItems(): HasMany
    {
        return $this->hasMany(SprintItem::class);
    }
}

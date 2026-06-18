<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// A desired piece of work at the project level. Estimation: ADR-0009.
class ProductBacklogItem extends Model
{
    use HasUlids, SoftDeletes;

    protected $guarded = [];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Sprint commitments of this item. */
    public function sprintItems(): HasMany
    {
        return $this->hasMany(SprintItem::class);
    }

    /** Sprints this item has been committed to (through sprint_items). */
    public function sprints(): BelongsToMany
    {
        return $this->belongsToMany(Sprint::class, 'sprint_items')
            ->withPivot(['id', 'status_id', 'committed_points', 'position'])
            ->withTimestamps();
    }

    public function blockers(): MorphMany
    {
        return $this->morphMany(Blocker::class, 'blockable');
    }
}

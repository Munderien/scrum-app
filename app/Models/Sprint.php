<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// Time-boxed iteration within a project. See ADR-0005.
class Sprint extends Model
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

    /** The sprint backlog (committed items). */
    public function items(): HasMany
    {
        return $this->hasMany(SprintItem::class);
    }

    /** PBIs committed to this sprint (through sprint_items). */
    public function backlogItems(): BelongsToMany
    {
        return $this->belongsToMany(ProductBacklogItem::class, 'sprint_items')
            ->withPivot(['id', 'status_id', 'committed_points', 'position'])
            ->withTimestamps();
    }

    public function blockers(): MorphMany
    {
        return $this->morphMany(Blocker::class, 'blockable');
    }
}

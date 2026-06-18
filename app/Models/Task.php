<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// Work to deliver a sprint item; self-references for subtasks. See ADR-0006.
class Task extends Model
{
    use HasUlids, SoftDeletes;

    protected $guarded = [];

    public function sprintItem(): BelongsTo
    {
        return $this->belongsTo(SprintItem::class);
    }

    /** Parent task (null for a top-level task). */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    /** Child tasks (subtasks). */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /** Reporter who created the task. */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Assigned users (task_user). */
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }

    public function blockers(): MorphMany
    {
        return $this->morphMany(Blocker::class, 'blockable');
    }
}

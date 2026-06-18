<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasUlids, SoftDeletes;

    protected $guarded = [];

    /** Team members, with their per-project role on the pivot. */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(Membership::class)
            ->withPivot('role_id')
            ->withTimestamps();
    }

    /** Raw membership rows (project_user). */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /** The product backlog (all PBIs for this project). */
    public function backlogItems(): HasMany
    {
        return $this->hasMany(ProductBacklogItem::class);
    }

    public function sprints(): HasMany
    {
        return $this->hasMany(Sprint::class);
    }

    /** Project-specific status overrides. */
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

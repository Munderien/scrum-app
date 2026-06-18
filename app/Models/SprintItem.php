<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// First-class model for sprint_items (sprint <-> PBI commitment) that also owns tasks. See ADR-0005.
class SprintItem extends Model
{
    use HasUlids, SoftDeletes;

    protected $guarded = [];

    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class);
    }

    public function backlogItem(): BelongsTo
    {
        return $this->belongsTo(ProductBacklogItem::class, 'product_backlog_item_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Tasks breaking down this committed item. */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}

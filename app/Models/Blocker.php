<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

// Impediment over Task / PBI / Sprint with a raised->resolved lifecycle. See ADR-0007.
class Blocker extends Model
{
    use HasUlids, SoftDeletes;

    protected $guarded = [];

    /** The blocked record (Task, ProductBacklogItem, or Sprint). */
    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }

    public function raiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'raised_by');
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

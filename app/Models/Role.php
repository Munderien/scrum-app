<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasUlids;

    protected $guarded = [];

    /** Memberships that hold this role. */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}

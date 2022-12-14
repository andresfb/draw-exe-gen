<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    /**
     * exercises Method.
     *
     * @return BelongsToMany
     */
    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }
}

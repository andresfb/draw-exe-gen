<?php

namespace App\Models;

use App\Traits\ConvertDateTimeToTimezone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Exercise extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, ConvertDateTimeToTimezone;

    protected $guarded = [];

    /** @var string[] */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /** @var string[] */
    protected $casts = [
        'min_repetitions' => 'integer',
        'max_repetitions' => 'integer',
        'is_rangable' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * random Method.
     *
     * @return Exercise
     */
    public static function random(): Exercise
    {
        return Exercise::whereActive(true)
            ->inRandomOrder()
            ->first();
    }


    /**
     * tools Method.
     *
     * @return BelongsToMany
     */
    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tools::class);
    }

    /**
     * registerMediaCollections Method.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('samples')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
            ])
            ->useDisk('media');
    }
}

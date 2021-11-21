<?php

namespace Hridoy\LaravelUserGuide\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserGuide extends Model
{
    protected $guarded = [];

    public function getPhotoAttribute($photo): ?string
    {
        $disk = config('user_guide.photo.disk');
        return $photo ? Storage::disk($disk)->url($photo) : null;
    }

    public function getVideoAttribute($video)
    {
        return $video;
    }

    public function userGuideCategory(): BelongsTo
    {
        return $this->belongsTo(UserGuideCategory::class);
    }
}

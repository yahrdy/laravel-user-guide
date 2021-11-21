<?php

namespace Hridoy\LaravelUserGuide\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class UserGuideCategory extends Model
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

    public function userGuides(): HasMany
    {
        return $this->hasMany(UserGuide::class);
    }
}

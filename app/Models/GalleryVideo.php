<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    protected $guarded = [];

    protected $table = 'gallery_videos';
    protected $primaryKey = 'gallery_video_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';
}


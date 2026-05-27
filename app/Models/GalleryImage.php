<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $guarded = [];

    protected $table = 'gallery_images';
    protected $primaryKey = 'gallery_image_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';
}


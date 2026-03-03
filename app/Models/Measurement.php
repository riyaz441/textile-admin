<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $guarded = [];

    protected $table = 'measurements';
    protected $primaryKey = 'measurement_id';
    public $timestamps = true;
    protected $keyType = 'int';
    public $incrementing = true;
}

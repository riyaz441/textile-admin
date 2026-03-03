<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMeasurement extends Model
{
    protected $table = 'product_measurements';
    protected $primaryKey = 'measurement_id';
    public $timestamps = false;
    protected $guarded = [];
}

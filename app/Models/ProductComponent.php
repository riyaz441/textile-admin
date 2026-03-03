<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    protected $table = 'product_components';
    protected $primaryKey = 'component_id';
    public $timestamps = true;
    protected $guarded = [];
    public $incrementing = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLabor extends Model
{
    protected $table = 'product_labor';
    protected $primaryKey = 'product_labor_id';
    public $timestamps = false;
    protected $guarded = [];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    protected $table = 'inventory_stocks';
    protected $primaryKey = 'stock_id';
    public $timestamps = true;
    protected $guarded = [];

    protected $casts = [
        'last_reorder_date' => 'date',
        'next_reorder_date' => 'date',
        'last_movement_date' => 'date',
        'average_cost' => 'decimal:2',
        'total_value' => 'decimal:2',
        'stock_turnover_rate' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function location()
    {
        return $this->belongsTo(LocationMaster::class, 'location_id', 'location_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CompanyScoped;

class SupplierMaster extends Model
{
    use CompanyScoped;

    protected $guarded = [];
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }
}

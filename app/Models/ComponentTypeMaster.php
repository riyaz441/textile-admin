<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyMaster;
use App\Models\Concerns\CompanyScoped;

class ComponentTypeMaster extends Model
{
    use CompanyScoped;

    protected $table = 'component_types';
    protected $primaryKey = 'type_id';
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id', 'company_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CompanyScoped;

class LaborMaster extends Model
{
    use CompanyScoped;

    protected $guarded = [];

    protected $table = 'labors';
    protected $primaryKey = 'labor_id';

    /**
     * Get the company associated with the labor.
     */
    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }
}

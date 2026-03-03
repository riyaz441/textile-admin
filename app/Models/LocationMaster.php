<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CompanyScoped;
use App\Models\BranchMaster; // ✅ ADD THIS LINE

class LocationMaster extends Model
{
    use CompanyScoped;

    protected $guarded = [];

    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Get the company associated with the location.
     */
    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }

    /**
     * Get the parent location.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_location_id');
    }

    /**
     * Get the child locations.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_location_id');
    }

    // ✅ ADD THIS FUNCTION (ONLY THIS)
    public function branch()
    {
        return $this->belongsTo(BranchMaster::class, 'branch_id', 'branch_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BranchMaster;
use App\Models\CompanyMaster;
use App\Models\Concerns\CompanyScoped;

class GemstoneMaster extends Model
{
    use CompanyScoped;

    protected $guarded = [];
    protected $table = 'gemstones';
    protected $primaryKey = 'gemstone_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id', 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(BranchMaster::class, 'branch_id', 'branch_id');
    }
}

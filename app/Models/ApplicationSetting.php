<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyMaster;
use App\Models\BranchMaster;

class ApplicationSetting extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'company_id',
        'branch_id',
        'setting_key',
        'setting_value',
        'setting_type',
        'category',
        'description',
    ];

    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id', 'company_id');
    }

    public function branch()
    {
        return $this->belongsTo(BranchMaster::class, 'branch_id', 'branch_id');
    }
}

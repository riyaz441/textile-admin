<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchMaster extends Model
{
    protected $guarded = [];

    protected $table = 'branches';
    protected $primaryKey = 'branch_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Get the company associated with the branch.
     */
    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }
}

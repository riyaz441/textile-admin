<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyMaster extends Model
{
    protected $guarded = [];

    protected $table = 'companies';
    protected $primaryKey = 'company_id';
    public $timestamps = true;
    protected $keyType = 'int';
    public $incrementing = true;
}
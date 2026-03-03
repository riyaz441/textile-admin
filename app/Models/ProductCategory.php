<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyMaster;
use App\Models\Concerns\CompanyScoped;

class ProductCategory extends Model
{
    use CompanyScoped;

    protected $guarded = [];
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_category_id', 'category_id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id', 'company_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CompanyScoped;

class Product extends Model
{
    use CompanyScoped;
    protected $table = 'products';

    protected $primaryKey = 'product_id';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Get the category associated with the product.
     */
    public function company()
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }
    /**
     * Get the category associated with the product.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategoryMaster::class, 'category_id', 'category_id');
    }

    /**
     * Get the material associated with the product.
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'material_id');
    }

    /**
     * Get the gemstone associated with the product.
     */
    public function gemstone()
    {
        return $this->belongsTo(GemstoneMaster::class, 'gemstone_id', 'gemstone_id');
    }

    /**
     * Get the supplier associated with the product.
     */
    public function supplier()
    {
        return $this->belongsTo(SupplierMaster::class, 'supplier_id', 'supplier_id');
    }
}

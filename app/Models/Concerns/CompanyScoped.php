<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait CompanyScoped
{
    protected static function bootCompanyScoped(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (app()->runningInConsole()) {
                return;
            }

            $companyId = session('company_id');
            if (!$companyId || $companyId === 'all') {
                return;
            }

            $table = $builder->getModel()->getTable();
            $builder->where($table . '.company_id', $companyId);
        });
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\CompanyMaster;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyContext
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $companies = CompanyMaster::where('status', 'Active')
            ->orderBy('company_name')
            ->get(['company_id', 'company_name']);

        $selectedCompanyId = $request->session()->get('company_id');

        if ($selectedCompanyId && $selectedCompanyId !== 'all' && !$companies->contains('company_id', $selectedCompanyId)) {
            $request->session()->forget('company_id');
            $selectedCompanyId = null;
        }

        if (!$selectedCompanyId) {
            $selectedCompanyId = 'all';
            $request->session()->put('company_id', $selectedCompanyId);
        }

        $companyLocked = $selectedCompanyId !== 'all';
        view()->share('companies', $companies);
        view()->share('selectedCompanyId', $selectedCompanyId);
        view()->share('companyLocked', $companyLocked);

        return $next($request);
    }
}

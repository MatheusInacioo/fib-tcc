<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $companyController = new CompanyController;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn () => $request->user()
                    ? $request->user()->load('role.permissions')
                    : null,
                'year' => now()->year,
                'selected_company_id' => session()->get('selected_company_id'),
                'selected_shop_id' => session()->get('selected_shop_id'),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'scope' => [
                'companies' => $companyController->list(),
            ]
        ];
    }
}

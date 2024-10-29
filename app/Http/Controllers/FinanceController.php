<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class FinanceController extends Controller
{
    public function index()
    {
        return Inertia::render('Finances/Index', []);
    }

    private function getFinancialData()
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $yesterdayStart = now()->subDay()->startOfDay();
        $yesterdayEnd = now()->subDay()->endOfDay();

        $todayInvoicing = Transaction::session()
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 1)
            ->sum('total_amount');

        $yesterdayInvoicing = Transaction::session()
            ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->where('type', 1)
            ->sum('total_amount');

        $purchases = Transaction::session()
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 0)
            ->count();

        $sales = Transaction::session()
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 1)
            ->count();

        $lowProducts = Product::whereColumn('total_amount', '<=', 'minimum_amount')->get();

        $expiredProducts = Product::session()->whereDate('expiry_date', '<', $todayStart)->get();

        $depletedProducts = Product::session()->where('total_amount', '0')->get();

        $change = $this->calculatePercentageChange($todayInvoicing, $yesterdayInvoicing);

        return [
            'invoicing' => [
                'total' => $todayInvoicing ? Number::currency($todayInvoicing, 'BRL') : null,
                'change' => $change !== null ? $change : null,
            ],
            'purchases' => $purchases ?? null,
            'sales' => $sales ?? null,
            'low_products' => $lowProducts ?? null,
            'expired_products' => $expiredProducts ?? null,
            'depleted_products' => $depletedProducts ?? null,
        ];
    }
}

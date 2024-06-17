<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Number;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'dayStats' => $this->getDayStats(),
        ]);
    }

    private function getDayStats()
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $yesterdayStart = now()->subDay()->startOfDay();
        $yesterdayEnd = now()->subDay()->endOfDay();

        $todayInvoicing = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 1)
            ->sum('total_amount');

        $yesterdayInvoicing = Transaction::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->where('type', 1)
            ->sum('total_amount');

        $entries = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 0)
            ->count();

        $outputs = Transaction::whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('type', 1)
            ->count();

        $lowProducts = Product::whereColumn('total_amount', '<=', 'minimum_amount')->get();

        $expiredProducts = Product::whereDate('expiry_date', '<', $todayStart)->count();

        $depletedProducts = Product::where('total_amount', '0')->get();

        $change = $this->calculatePercentageChange($todayInvoicing, $yesterdayInvoicing);

        return [
            'invoicing' => [
                'total' => $todayInvoicing ? Number::currency($todayInvoicing, 'BRL') : null,
                'change' => $change !== null ? $change : null,
            ],
            'entries' => $entries ?? null,
            'outputs' => $outputs ?? null,
            'low_products' => $lowProducts ?? null,
            'expired_products' => $expiredProducts ?? null,
            'depleted_products' => $depletedProducts ?? null,
        ];
    }

    public function filterData($period, $chartType)
    {
        $data = [];

        switch ($chartType) {
            case 'invoicing':
                $data = $this->getInvoicingData($period);
                break;
            case 'entries':
                $data = $this->getEntriesData($period);
                break;
            case 'outputs':
                $data = $this->getOutputsData($period);
                break;
            default:
                $data = [];
        }

        return $data;
    }

    private function calculatePercentageChange($currentValue, $previousValue)
    {
        if ($previousValue == 0) {
            return $currentValue == 0 ? '0%' : '+100%';
        }

        $change = round((($currentValue - $previousValue) / $previousValue) * 100, 2);
        $sign = $change > 0 ? '+' : '';

        return $sign . $change . '%';
    }

    private function getInvoicingData($period)
    {
        $invoicingData = [];

        for ($i = 0; $i < $period; $i++) {
            $startDate = now()->subDays($i)->startOfDay();
            $endDate = now()->subDays($i)->endOfDay();

            $invoicing = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 1)
                ->sum('total_amount');

            $date = $startDate->format('d/m');
            $invoicingData[$date] = $invoicing;
        }

        return array_reverse($invoicingData);
    }

    private function getEntriesData($period)
    {
        $entriesData = [];

        for ($i = 0; $i < $period; $i++) {
            $startDate = now()->subDays($i)->startOfDay();
            $endDate = now()->subDays($i)->endOfDay();

            $entries = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 0)
                ->count();

            $date = $startDate->format('d/m');
            $entriesData[$date] = $entries;
        }

        return array_reverse($entriesData);
    }

    private function getOutputsData($period)
    {
        $outputsData = [];

        for ($i = 0; $i < $period; $i++) {
            $startDate = now()->subDays($i)->startOfDay();
            $endDate = now()->subDays($i)->endOfDay();

            $outputs = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 1)
                ->count();

            $date = $startDate->format('d/m');
            $outputsData[$date] = $outputs;
        }

        return array_reverse($outputsData);
    }
}

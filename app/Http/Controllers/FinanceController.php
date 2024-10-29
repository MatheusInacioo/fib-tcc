<?php

namespace App\Http\Controllers;

use App\Utils\NumericUtil;
use App\Models\Expense;
use App\Models\Transaction;
use Inertia\Inertia;

class FinanceController extends Controller
{
    public function index()
    {
        return Inertia::render('Finances/Index', [
            'financialData' => $this->getFinancialData(),
        ]);
    }

    private function getFinancialData()
    {
        $currentYear = now()->year;
        $financialData = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = now()->setYear($currentYear)->setMonth($month)->startOfMonth();
            $endOfMonth = now()->setYear($currentYear)->setMonth($month)->endOfMonth();

            $invoicing = Transaction::session()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('type', 1)
                ->sum('total_amount');

            $expenses = Expense::session()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $grossProfit = $invoicing - $expenses;

            $salesCount = Transaction::session()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('type', 1)
                ->count();

            $averageTicket = $salesCount > 0 ? $invoicing / $salesCount : 0;

            $financialData[] = [
                'period' => $startOfMonth->format('m/Y'),
                'invoicing' => NumericUtil::formatToCurrency($invoicing, 'R$'),
                'expenses' => NumericUtil::formatToCurrency($expenses, 'R$'),
                'gross_profit' => NumericUtil::formatToCurrency($grossProfit, 'R$'),
                'profit_margin' => NumericUtil::getProfitMarginValue($invoicing, $grossProfit),
                'average_ticket' => NumericUtil::formatToCurrency($averageTicket, 'R$'),
                'sales_count' => $salesCount,
            ];
        }

        return $financialData;
    }

    public function export()
    {
        // 
    }
}

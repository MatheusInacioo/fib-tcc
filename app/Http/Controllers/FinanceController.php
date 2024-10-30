<?php

namespace App\Http\Controllers;

use App\Utils\NumericUtil;
use App\Models\Expense;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinanceController extends Controller
{
    public function index()
    {
        return Inertia::render('Finances/Index', [
            'financialData' => $this->getFinancialData(),
        ]);
    }

    public function fetchData(Request $request)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            return $this->getFinancialData(
                intval($request['group_by']),
                intval($request['interval']),
                $request['start_date'],
                $request['end_date']
            );
        }

        return $this->getFinancialData(
            intval($request['group_by']),
            intval($request['interval']),
        );
    }

    private function getFinancialData(
        $groupBy = 1, 
        $interval = 1,
        $startDate = null, 
        $endDate = null, 
    ) {
        switch ($groupBy) {
            case 1: // per day
                $startDate = Carbon::now()->subDays(30);
                $endDate = Carbon::now();
                break;

            case 2: // per month
                $startDate = Carbon::now()->subMonths(6)->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case 3: // per year
                $startDate = Carbon::now()->subYear()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case 4: // custom
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate = Carbon::parse($endDate)->endOfDay();
                } else {
                    throw new \Exception("As datas de início e fim são obrigatórias para o período personalizado.");
                }
                break;
        }

        $interlvalPeriod = $interval === 1 ? new \DateInterval('P1D') : new \DateInterval('P1M');
        $periods = new \DatePeriod(
            new \DateTime($startDate),
            $interlvalPeriod,
            (new \DateTime($endDate))->modify('+1 ' . ($interval === 1 ? 'day' : 'month'))
        );

        $financialData = [];

        foreach ($periods as $date) {
            $startOfPeriod = Carbon::instance($date)->startOf($interval === 1 ? 'day' : 'month');
            $endOfPeriod = Carbon::instance($date)->endOf($interval === 1 ? 'day' : 'month');

            $invoicing = Transaction::session()
                ->whereBetween('created_at', [$startOfPeriod, $endOfPeriod])
                ->where('type', 1)
                ->sum('total_amount');

            $expenses = Expense::session()
                ->whereBetween('created_at', [$startOfPeriod, $endOfPeriod])
                ->sum('amount');

            $grossProfit = $invoicing - $expenses;

            $salesCount = Transaction::session()
                ->whereBetween('created_at', [$startOfPeriod, $endOfPeriod])
                ->where('type', 1)
                ->count();

            $averageTicket = $salesCount > 0 ? $invoicing / $salesCount : 0;

            $financialData[] = [
                'period' => $startOfPeriod->format($interval === 1 ? 'd/m/Y' : 'm/Y'),
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

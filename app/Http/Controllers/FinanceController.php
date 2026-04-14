<?php

namespace App\Http\Controllers;

use App\Enums\FinanceGroupByEnum;
use App\Enums\FinanceReportIntervalEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Expense;
use App\Models\Transaction;
use App\Utils\NumericUtil;
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
        int $groupBy = 1,
        int $interval = 1,
        $startDate = null,
        $endDate = null,
    ) {
        $GROUP_BY_ENUM = FinanceGroupByEnum::tryFrom($groupBy) ?? FinanceGroupByEnum::LAST_30_DAYS;
        $INTERVAL_ENUM = FinanceReportIntervalEnum::tryFrom($interval) ?? FinanceReportIntervalEnum::DAILY;

        switch ($GROUP_BY_ENUM) {
            case FinanceGroupByEnum::LAST_30_DAYS:
                $startDate = Carbon::now()->subDays(30);
                $endDate = Carbon::now();
                break;

            case FinanceGroupByEnum::LAST_6_MONTHS:
                $startDate = Carbon::now()->subMonths(6)->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case FinanceGroupByEnum::LAST_12_MONTHS:
                $startDate = Carbon::now()->subYear()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case FinanceGroupByEnum::CUSTOM_RANGE:
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate = Carbon::parse($endDate)->endOfDay();
                } else {
                    throw new \Exception('As datas de início e fim são obrigatórias para o período personalizado.');
                }
                break;
        }

        $INTERVAL_PERIOD = $INTERVAL_ENUM === FinanceReportIntervalEnum::DAILY
            ? new \DateInterval('P1D')
            : new \DateInterval('P1M');
        $PERIODS = new \DatePeriod(
            new \DateTime($startDate),
            $INTERVAL_PERIOD,
            (new \DateTime($endDate))->modify('+1 '.($INTERVAL_ENUM === FinanceReportIntervalEnum::DAILY ? 'day' : 'month'))
        );

        $FINANCIAL_DATA = [];

        foreach ($PERIODS as $DATE) {
            $START_OF_PERIOD = Carbon::instance($DATE)->startOf($INTERVAL_ENUM === FinanceReportIntervalEnum::DAILY ? 'day' : 'month');
            $END_OF_PERIOD = Carbon::instance($DATE)->endOf($INTERVAL_ENUM === FinanceReportIntervalEnum::DAILY ? 'day' : 'month');

            $INVOICING = Transaction::session()
                ->whereBetween('created_at', [$START_OF_PERIOD, $END_OF_PERIOD])
                ->where('type', TransactionTypeEnum::SALE)
                ->sum('total_amount');

            $EXPENSES = Expense::session()
                ->whereBetween('created_at', [$START_OF_PERIOD, $END_OF_PERIOD])
                ->sum('amount');

            $GROSS_PROFIT = $INVOICING - $EXPENSES;

            $SALES_COUNT = Transaction::session()
                ->whereBetween('created_at', [$START_OF_PERIOD, $END_OF_PERIOD])
                ->where('type', TransactionTypeEnum::SALE)
                ->count();

            $AVERAGE_TICKET = $SALES_COUNT > 0 ? $INVOICING / $SALES_COUNT : 0;

            $FINANCIAL_DATA[] = [
                'period' => $START_OF_PERIOD->format($INTERVAL_ENUM === FinanceReportIntervalEnum::DAILY ? 'd/m/Y' : 'm/Y'),
                'invoicing' => NumericUtil::formatToCurrency($INVOICING, 'R$'),
                'expenses' => NumericUtil::formatToCurrency($EXPENSES, 'R$'),
                'gross_profit' => NumericUtil::formatToCurrency($GROSS_PROFIT, 'R$'),
                'profit_margin' => NumericUtil::getProfitMarginValue($INVOICING, $GROSS_PROFIT),
                'average_ticket' => NumericUtil::formatToCurrency($AVERAGE_TICKET, 'R$'),
                'sales_count' => $SALES_COUNT,
            ];
        }

        return $FINANCIAL_DATA;
    }

    public function export()
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportChartController extends Controller
{
    //
    public function getIncomeExpenseOverTime()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->selectRaw('DATE(date) as day, SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income, SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expenses')
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $chartData = [
            'labels' => $transactions->pluck('day'),
            'datasets' => [
                [
                    'label' => 'Income',
                    'backgroundColor' => '#28a745',
                    'borderColor' => '#28a745',
                    'data' => $transactions->pluck('total_income'),
                    'fill' => false,
                ],
                [
                    'label' => 'Expenses',
                    'backgroundColor' => '#dc3545',
                    'borderColor' => '#dc3545',
                    'data' => $transactions->pluck('total_expenses'),
                    'fill' => false,
                ],
            ],
        ];

        return view('reports.income-expense-over-time', compact('chartData'));
    }


    public function getCategoryBreakdown()
    {
        $expenses = Transaction::where('user_id', auth()->id())
            ->where('type', 'expense')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $chartData = [
            'labels' => $expenses->pluck('category.name'),
            'datasets' => [
                [
                    'data' => $expenses->pluck('total'),
                    'backgroundColor' => ['#f87979', '#4BC0C0', '#36A2EB', '#FFCE56'],
                ],
            ],
        ];

        return view('reports.category-breakdown', compact('chartData'));
    }


    public function getBudgetVsActual()
    {
        $budgets = Budget::where('user_id', auth()->id())
            ->with(['category', 'transactions' => function ($query) {
                $query->where('type', 'expense');
            }])
            ->get();

        $chartData = [
            'labels' => $budgets->pluck('category.name'),
            'datasets' => [
                [
                    'label' => 'Budget',
                    'backgroundColor' => '#36A2EB',
                    'data' => $budgets->pluck('amount'),
                ],
                [
                    'label' => 'Actual Expenses',
                    'backgroundColor' => '#FF6384',
                    'data' => $budgets->map(function ($budget) {
                        return $budget->transactions->sum('amount');
                    }),
                ],
            ],
        ];

        return view('reports.budget-vs-actual', compact('chartData'));
    }

    public function getRecurringVsNonRecurring()
    {
        $recurring = Transaction::where('user_id', auth()->id())
            ->where('is_recurring', true)
            ->sum('amount');

        $nonRecurring = Transaction::where('user_id', auth()->id())
            ->where('is_recurring', false)
            ->sum('amount');

        $chartData = [
            'labels' => ['Recurring', 'Non-Recurring'],
            'datasets' => [
                [
                    'data' => [$recurring, $nonRecurring],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                ],
            ],
        ];

        return view('reports.recurring-vs-nonrecurring', compact('chartData'));
    }


    public function getMonthlySummary()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income, SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expenses')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $chartData = [
            'labels' => $transactions->pluck('month'),
            'datasets' => [
                [
                    'label' => 'Income',
                    'backgroundColor' => '#28a745',
                    'data' => $transactions->pluck('total_income'),
                ],
                [
                    'label' => 'Expenses',
                    'backgroundColor' => '#dc3545',
                    'data' => $transactions->pluck('total_expenses'),
                ],
            ],
        ];

        return view('reports.monthly-summary', compact('chartData'));
    }



}

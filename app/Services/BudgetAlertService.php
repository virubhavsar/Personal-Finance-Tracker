<?php

namespace App\Services;

use App\Mail\BudgetAlertMail;
use App\Models\Budget;
use App\Models\Transaction;
use App\Notifications\BudgetAlertNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BudgetAlertService
{
    public function checkBudgets($userId)
    {
        $today = Carbon::today();
        $budgets = Budget::where('user_id', $userId)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        foreach ($budgets as $budget) {
            $this->checkBudget($budget);
        }
    }

    protected function checkBudget(Budget $budget)
    {
        $totalExpenses = Transaction::where('user_id', $budget->user_id)
            ->where('type', 'expense')
            ->whereBetween('date', [$budget->start_date, $budget->end_date])
            ->sum('amount');

        $threshold = $budget->amount * 0.9; // 90% threshold

        if ($totalExpenses >= $threshold && $totalExpenses < $budget->amount) {
            $this->sendAlert($budget, 'approaching');
        } elseif ($totalExpenses >= $budget->amount) {
            $this->sendAlert($budget, 'exceeded');
        }
    }

    protected function sendAlert(Budget $budget, $status)
    {
        $user = $budget->user;
        $message = '';

        if ($status == 'approaching') {
            $message = "You are approaching your budget limit for the category.";
        } elseif ($status == 'exceeded') {
            $message = "You have exceeded your budget limit for the category.";
        }

        $user->notify(new BudgetAlertNotification($message));
    }
}

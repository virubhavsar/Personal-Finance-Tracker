<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Budget;
use Carbon\Carbon;

class RepeatBudgetForNextMonth extends Command
{
    protected $signature = 'budget:repeat-next-month';
    protected $description = 'Repeat budgets for the next month if repeat_every_month is set to yes';

    public function handle()
    {
        $budgets = Budget::where('repeat_every_month', 'yes')->get();

        foreach ($budgets as $budget) {
            // Original start and end dates
            $originalStartDate = Carbon::parse($budget->start_date);
            $originalEndDate = Carbon::parse($budget->end_date);

            // Calculate next month's start and end dates
            $nextMonthStartDate = $this->getNextMonthDate($originalStartDate);
            $nextMonthEndDate = $this->getNextMonthDate($originalEndDate);

            // Check if the budget already exists for the next month
            $existingBudget = Budget::where('user_id', $budget->user_id)
                ->where('category_id', $budget->category_id)
                ->where('start_date', $nextMonthStartDate)
                ->where('end_date', $nextMonthEndDate)
                ->first();

            if (!$existingBudget) {
                // Create a new budget for the next month
                Budget::create([
                    'user_id' => $budget->user_id,
                    'category_id' => $budget->category_id,
                    'amount' => $budget->amount,
                    'start_date' => $nextMonthStartDate,
                    'end_date' => $nextMonthEndDate,
                    'repeat_every_month' => $budget->repeat_every_month,
                ]);
            }
        }

        $this->info('Budgets have been repeated for the next month.');
    }

    private function getNextMonthDate(Carbon $date)
    {
        // Add one month to the date
        $nextMonthDate = $date->copy()->addMonth();

        // Check if the next month has fewer days than the current day
        if ($nextMonthDate->day !== $date->day) {
            // Set to the last day of the next month if the day is out of range
            $nextMonthDate = $nextMonthDate->endOfMonth();
        }

        return $nextMonthDate;
    }
}

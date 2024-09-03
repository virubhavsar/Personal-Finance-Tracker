<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\BudgetAlertService;
use Illuminate\Console\Command;

class CheckBudgetAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'budget:check-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $budgetAlertService;

    public function __construct(BudgetAlertService $budgetAlertService)
    {
        parent::__construct();
        $this->budgetAlertService = $budgetAlertService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('role','2')->get();

        foreach ($users as $user) {
            $this->budgetAlertService->checkBudgets($user->id);
        }

        $this->info('Budget alerts checked and notifications sent if necessary.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoFlagOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-flag-overdue-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically flag overdue tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Task::where('due_date', '<', Carbon::today())
            ->where('status', '!=', 'done')
            ->update(['status' => 'overdue']);

        $this->info("$count tasks flagged as overdue.");
    }
}

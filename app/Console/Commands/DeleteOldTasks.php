<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Task;

class DeleteOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks that are 30 days old';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->subDays(30);
        Task::where('created_at', '<', $date)->delete();

        $this->info('Old tasks deleted successfully.');
    }
}

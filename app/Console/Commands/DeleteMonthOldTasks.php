<?php

namespace App\Console\Commands;

use App\Services\TaskService;
use Illuminate\Console\Command;

class DeleteMonthOldTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-month-old-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be deleting tasks that are already a month old';

    /**
     * The default days when to delete tasks
     * 
     * @var int
     */
    private const DEFAULT_DAYS = 30;

    /**
     * @var TaskService $taskService
     */
    private TaskService $taskService;

    /**
     * @param TaskService $taskService
     * 
     * @return void
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->taskService->delete([
                'days_past' => self::DEFAULT_DAYS
            ]);

            $this->info('Successfully deleted month old tasks.');
        } catch (\Exception $exception) {
            logger()
                ->exception(
                    sprintf('%s: %s', __METHOD__, $exception->getMessage()),
                    ['trace' => $exception->getTraceAsString()]
                );

            $this->error('Unexpected error occurred. Please check the logs.');
        }
    }
}

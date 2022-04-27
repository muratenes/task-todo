<?php

namespace App\Console\Commands;

use App\Library\Services\TodoService\ToDoService;
use Illuminate\Console\Command;

class UpdateTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all task from provided apis';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new ToDoService())->updateTasks([
            new \App\Library\Services\TodoService\Providers\FirstProvider(),
            new \App\Library\Services\TodoService\Providers\SecondProvider(),
        ]);
        $this->warn("All task updated");

        return 0;
    }
}

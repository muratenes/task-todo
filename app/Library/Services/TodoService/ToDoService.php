<?php

namespace App\Library\Services\TodoService;

use App\Library\Services\TodoService\Enums\TodoEnum;
use App\Models\Task;
use App\Models\User;
use App\Models\Work;

class ToDoService
{
    /**
     * update tasks from providers.
     *
     * @param array[ProviderInterface] $providers
     * @return void
     */
    public function updateTasks(array $providers)
    {
        foreach ($providers as $provider) {
            $provider->updateTasksFromAPI();
        }
    }


    /**
     * create works from unassigned tasks.
     *
     * @return void
     */
    public function createWorksFromPendingTasks()
    {
        $users = User::orderByDesc('power')->get();
        $totalTaskHour = (int)Task::whereNull('user_id')->sum('hour');
        $jobTotalWeekCount = ceil($totalTaskHour / $this->getWorkHourPerWeek());
        for ($i = 1; $i <= $jobTotalWeekCount; $i++) {
            $tasks = Task::whereNull('user_id')->orderByDesc('difficulty')->get();
            $totalSubmittedWorkHour = 0;
            foreach ($tasks as $task) {
                if ($totalSubmittedWorkHour >= $this->getWorkHourPerWeek()) {
                    continue 2;
                }
                foreach ($users as $user) {
                    $userWorkHourByWeek = Work::where(['user_id' => $user->id, 'week_number' => $i])->sum('hour');
                    if ($task and $task->user_id) {
                        $task = Task::whereNull('user_id')->where('hour', '<=', TodoEnum::WORKER_WEEKLY_HOUR_COUNT - $userWorkHourByWeek)->first();
                    }
                    if ($task and $userWorkHourByWeek + $task->hour <= TodoEnum::WORKER_WEEKLY_HOUR_COUNT) {
                        if (!Work::where('task_id', $task->id)->count()) {
                            Work::create(['user_id' => $user->id, 'task_id' => $task->id, 'week_number' => $i, 'hour' => $task->hour]);
                            $task->update(['user_id' => $user->id]);
                            $totalSubmittedWorkHour += $task->hour;
                        }
                    }
                }
            }

        }
    }


    /**
     * tüm developerler haftalik kaç saat iş yapabilir ?
     *
     * @return int
     */
    public function getWorkHourPerWeek(): int
    {
        return User::count() * 45;
    }
}

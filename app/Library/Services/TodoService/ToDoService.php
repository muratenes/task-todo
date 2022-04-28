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
            foreach ($users as $user) {
                $tasks = Task::whereNull('user_id')->orderByDesc('difficulty')->get();
                $userWorkHourByWeek = Work::where(['user_id' => $user->id, 'week_number' => $i])->sum('hour');
                foreach ($tasks as $task) {
                    if ($userWorkHourByWeek + $task->hour <= 45) {
                        Work::create(['user_id' => $user->id, 'task_id' => $task->id, 'week_number' => $i, 'hour' => $task->hour]);
                        $task->update(['user_id' => $user->id]);
                        $userWorkHourByWeek += $task->hour;
                    } else {
                        $lastTask = Task::whereNull('user_id')->where('hour', '<=', TodoEnum::WORKER_WEEKLY_HOUR_COUNT - $userWorkHourByWeek)->first();
                        if ($lastTask) {
                            Work::create(['user_id' => $user->id, 'task_id' => $lastTask->id, 'week_number' => $i, 'hour' => $lastTask->hour]);
                            $lastTask->update(['user_id' => $user->id]);
                        }
                        break;
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
    public function getWorkHourPerWeek() : int
    {
        return User::count() * 45;
    }
}

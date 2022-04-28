<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        Work::truncate();
        Task::whereNotNull('user_id')->update(['user_id' => null]);
        $users = User::orderByDesc('power')->get();
        $totalTaskHour = (int)Task::whereNull('user_id')->sum('hour');
        $jobTotalWeekCount = ceil($totalTaskHour / $this->getWorkHourPerWeek());
        for ($i = 1; $i <= $jobTotalWeekCount; $i++) {
            $tasks = Task::whereNull('user_id')->orderByDesc('difficulty')->get();
            foreach ($users as $user) {
                $userWorkHourByWeek = Work::where(['user_id' => $user->id, 'week_number' => $i])->sum('hour');
                foreach ($tasks as $task) {
                    if ($userWorkHourByWeek + $task->hour <= 45) {
                        Work::create(['user_id' => $user->id, 'task_id' => $task->id, 'week_number' => $i, 'hour' => $task->hour]);
                        $task->update(['user_id' => $user->id]);
                        $userWorkHourByWeek += $task->hour;
                    } else {
                        $lastTask = Task::whereNull('user_id')->where('hour', '<=', 45 - $userWorkHourByWeek)->first();
                        if ($lastTask) {
                            Work::create(['user_id' => $user->id, 'task_id' => $lastTask->id, 'week_number' => $i, 'hour' => $lastTask->hour]);
                            $lastTask->update(['user_id' => $user->id]);
                        }
                        break;
                    }
                }

            }
        }
        return "Tüm tasklar kullanıcılara atandı. /works sayfasını ziyaret edebilirsiniz.";
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

    public function works()
    {
        $works = Work::orderBy('week_number')->get();

        return view('works', [
            'works' => $works
        ]);
    }
}

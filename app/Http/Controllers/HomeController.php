<?php

namespace App\Http\Controllers;

use App\Library\Services\TodoService\ToDoService;
use App\Models\Task;
use App\Models\Work;

class HomeController extends Controller
{
    /**
     * create works
     * @return string
     */
    public function createWorks()
    {
        // test amaçlı tüm işler silinmiştir.
        Work::truncate();
        Task::whereNotNull('user_id')->update(['user_id' => null]);

        (new ToDoService())->createWorksFromPendingTasks();

        return "Tüm bekleyen tasklar kullanıcılara atandı. /works sayfasını ziyaret edebilirsiniz.";
    }


    /**
     * list works
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function works()
    {
        $works = Work::orderBy('week_number')->get();

        return view('works', [
            'works' => $works
        ]);
    }
}

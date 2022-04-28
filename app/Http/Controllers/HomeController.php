<?php

namespace App\Http\Controllers;

use App\Library\Services\TodoService\ToDoService;
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
        (new ToDoService())->createWorksFromPendingTasks();
        return "Tüm tasklar kullanıcılara atandı. /works sayfasını ziyaret edebilirsiniz.";
    }



    public function works()
    {
        $works = Work::orderBy('week_number')->get();

        return view('works', [
            'works' => $works
        ]);
    }
}

<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        @foreach($works->groupBy('week_number') as $works)
            <div class=" col-md-3">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <td colspan="4" class="text-center"><b>Hafta : {{ $works->first()->week_number }}</b></td>
                        </tr>
                        <th scope="col">İşçi</th>
                        <th scope="col">Task</th>
                        <th scope="col">Saat</th>
                        <th scope="col">Hafta</th>
                    </thead>
                    <tbody>
                    @foreach($works->sortBy('user_id')->groupBy('user_id') as $user => $userWorks)

                        <tr>
                            <td colspan="4" class="text-center"><b>{{ optional($userWorks->first()->user)->name }} (Haftalık işi : {{ $works->where('user_id',$userWorks->first()->user_id)->sum('hour') }} saat )</b></td>
                        </tr>
                        @foreach($userWorks as $userWork)
                            <tr>
                                <td scope="row">{{ $userWork->user->name }}</td>
                                <td>{{ $userWork->task->id }}</td>
                                <td>{{ $userWork->hour }}</td>
                                <td>{{ $userWork->week_number }}</td>
                            </tr>
                        @endforeach

                    @endforeach
                    </tbody>
                </table>
            </div>

        @endforeach
    </div>
</div>
</body>
</html>



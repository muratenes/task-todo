<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        @foreach($works->groupBy('week_number') as $works)
            <div class=" col-md-6">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                    <tr><b>Hafta : {{ $works->first()->week_number }}</b></tr>
                    <th scope="col">İşçi</th>
                    <th scope="col">Task</th>
                    <th scope="col">Saat</th>
                    <th scope="col">Hafta</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($works->sortBy('user_id') as $work)
                        <tr>
                            <td scope="row">{{ $work->user->name }}(Haftalık işi : {{ $works->where('user_id',$work->user_id)->sum('hour') }} )</td>
                            <td>{{ $work->task->id }}</td>
                            <td>{{ $work->hour }}</td>
                            <td>{{ $work->week_number }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @endforeach
    </div>
</div>
</body>
</html>



<!DOCTYPE html>
<html>
<head>
    <style>
        table, th, td {

            font-family: arial, sans-serif;
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {

            width: 100%;
        }

        td, th {

            text-align: left;
        }
    </style>
</head>
<body>

<div>
    <h1>Candidates report</h1>
    <table >
        <thead>
        <tr>
            <th >Id candidate</th>
            <th >Job opening Id</th>
            <th >position</th>
            <th >Name</th>
            <th >Last name</th>
            <th >User id</th>
            <th >Email</th>
            <th >Stage</th>
            <th >Status</th>
        </tr>
        </thead>
        <tbody>
        @if(count($candidates))
            @foreach($candidates as $candidate)
                <tr>
                    <th>{{$candidate->id}}</th>
                    <td>{{$candidate->job_opening_id}}</td>
                    <td>{{$candidate->job_opening->position}}</td>
                    <td>{{$candidate->user->first_name}}</td>
                    <td>{{$candidate->user->last_name}}</td>
                    <td>{{$candidate->user->id}}</td>
                    <td>{{$candidate->user->email}}</td>
                    @if($candidate->stage != null)
                        <td>{{$candidate->stage->name}}</td>
                    @else
                        <td>No stage yet</td>
                    @endif

                    <td>{{$candidate->status}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

</body>
</html>

@extends('adminlte::page')
@section('content')

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <table id="listtable" class="table table-bordered table-striped table-condensed dataTable no-footer" role="grid"
           aria-describedby="listtable_info">
        <thead class="bg-danger">
        {{--        <thead class="thead-dark">--}}
        <tr>
            <th scope="col">#</th>
            <th scope="col">Task Title</th>
            <th scope="col">Task Description</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <th scope="row">{{$task->id}}</th>
                <td><a href="/tasks/{{$task->id}}">{{$task->title}}</a></td>
                <td>{{$task->description}}</td>
                <td>{{$task->created_at->toFormattedDateString()}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ URL::to('tasks/' . $task->id . '/edit') }}" class="fa fa-pencil-square"
                           style="color:darkgreen">
                        </a>&nbsp;
                        |
                        <a href="{{ URL::to('tasks/' . $task->id . '/delete') }}" class="fa fa-trash"
                           style="color: red">
                        </a>&nbsp;
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>


<script>
    $(document).ready(function () {
        $('#listtable').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ]
        });
    });
</script>
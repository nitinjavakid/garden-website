@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Plant - {{ $plant->name }}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel panel-default">
                    <div class="panel-heading">Tasks</div>
                    <ul class="list-group">
                    @foreach ($plant->tasks as $task)
                        <li class="list-group-item">
                            <a href="/task/{{ $task->id }}">
                                {{ $task->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                    </div>

                    <div class="panel panel-default">
                    <div class="panel-heading">Events</div>
                    <table class="table">
                    <thead>
                       <tr>
                          <th>Id</th>
                          <th>Time</th>
                          <th>Flip</th>
                          <th>Value</th>
                          <th>Watered</th>
                          <th>Task</th>
                       </tr>
                    </thead>
                    @foreach ($events as $event)
                        <tr class="{{ $event->watered ? "success" : "" }}">
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->created_at }}</td>
                            <td>{{ $event->flip }}</td>
                            <td>{{ $event->value }}</td>
                            <td>{{ $event->watered }}</td>
                            <td>{{ $event->task->name }}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                <nav>
                    <center>{{ $events }}</center>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

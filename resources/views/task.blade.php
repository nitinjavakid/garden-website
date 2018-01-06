@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Task
                @if ($task->id != null)
                - {{ $task->name }}
                @endif
            </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel panel-default">
                       <div class="panel-heading">Config</div>
                       <div class="panel-body">
                          {{ Form::model($task, [
                                "route" => [$task->id != null ? 'task.update' : 'task.store', $task->id],
                                "method" => $task->id != null ? "PUT" : "POST"
                               ])
                          }}
                          <div class="form-group">
                             {{ Form::hidden("plant_id") }}
                             {{ Form::label('name', 'Name') }}
                             {{ Form::text("name", null, ["class" => "form-control"]) }}

                             {{ Form::label('time_interval', 'Time interval') }}
                             {{ Form::text("time_interval", null, ["class" => "form-control"]) }}

                             {{ Form::label('watering_system', 'Watering System') }}
                             {{ Form::select('watering_system_index', $watering_systems, null, ["class" => "form-control"]) }}

                             @foreach($task->watering_system->needProperties() as $key => $value)
                             {{ Form::label('system_' . $key, $value) }}
                             {{ Form::text(null, $task->watering_system->getProperty($key), ["name" => "system_" . $key, "class" => "form-control"]) }}
                             @endforeach

                             <div class="checkbox">
                                 <label>
                                     {{ Form::checkbox("enabled") }} Enabled
                                 </label>
                             </div>
                          </div>
                          {{ Form::submit("Save", [ "class" => "btn btn-default"]) }}
                          {{ Form::close() }}
                       </div>
                    </div>

                    @if ($task->id != null)
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
                             </tr>
                          </thead>
                          @foreach ($events as $event)
                          <tr class="{{ $event->watered ? "success" : "" }}">
                             <td>{{ $event->id }}</td>
                             <td>{{ $event->created_at }}</td>
                             <td>{{ $event->flip }}</td>
                             <td>{{ $event->value }}</td>
                             <td>{{ $event->watered }}</td>
                          </tr>
                          @endforeach
                       </table>
                    </div>
                    <nav>
                        <center>{{ $events }}</center>
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

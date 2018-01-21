@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Plant
                @if ($plant->id != null)
                    - {{ $plant->name }}
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
                          {{ Form::model($plant, [
                                "route" => [$plant->id != null ? 'plant.update' : 'plant.store', $plant->id],
                                "method" => $plant->id != null ? "PUT" : "POST"
                               ])
                          }}
                          <div class="form-group">
                             {{ Form::hidden("device_id") }}
                             {{ Form::label('name', 'Name') }}
                             {{ Form::text("name", null, ["class" => "form-control"]) }}
                             {{ Form::label("forward_pin", "Forward Pin") }}
                             {{ Form::pinSelect("forward_pin") }}

                             {{ Form::label("reverse_pin", "Reverse Pin") }}
                             {{ Form::pinSelect("reverse_pin") }}

                             {{ Form::label("adc_pin", "ADC Pin") }}
                             {{ Form::pinSelect("adc_pin") }}

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

                    @if ($plant->id != null)
                    <div class="panel panel-default">
                       <div class="panel-heading">
                          <div class="panel-title pull-left">Tasks</div>
                          {{ link_to_route('task.create', "New", ["plant" => $plant->id], [ "class" => "btn btn-primary btn-sm pull-right"]) }}
                          <div class="clearfix"></div>
                       </div>
                       <ul class="list-group">
                       @foreach ($plant->tasks as $task)
                          <li class="list-group-item">
                            {{ link_to_route("task.show", $task->name, $task->id, ["class" => "pull-left" ]) }}
                            {{ Form::open(["route" => ["task.destroy",  $task->id], "method" => "DELETE"]) }}
                            {{ Form::submit("Delete", ["class" => "btn btn-danger btn-sm pull-right", "onClick" => 'return confirmDelete(this)', "data-name" => $task->name]) }}
                            {{ Form::close() }}
                            <div class="clearfix"></div>
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
                             <td>{{ Timezone::convertFromUTC($event->created_at, Auth::user()->timezone, 'Y-m-d H:i:s') }}</td>
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
                    @endif
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

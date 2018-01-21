@extends('layouts.app')

@section('content')
<div class="container">
    {{ Breadcrumbs::render('device', $device) }}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Device
                @if ($device->id != null)
                    - {{ $device->name }}</div>
                @endif

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel panel-default">
                       <div class="panel-heading">Config</div>
                       <div class="panel-body">
                          {{ Form::model($device, [
                                "route" => [$device->id != null ? 'device.update' : 'device.store', $device->id],
                                "method" => $device->id != null ? "PUT" : "POST"
                               ])
                          }}
                          <div class="form-group">
                             {{ Form::hidden("garden_id") }}
                             {{ Form::label('name', 'Name') }}
                             {{ Form::text("name", null, ["class" => "form-control"]) }}

                             {{ Form::label('secret', 'Secret') }}
                             {{ Form::password("secret", ["class" => "form-control"]) }}

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

                @if ($device->id != null)
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title pull-left">Plants</div>
                        {{ link_to_route('plant.create', "New", ["device" => $device->id], [ "class" => "btn btn-primary btn-sm pull-right"]) }}
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-group">
                    @foreach ($device->plants as $plant)
                        <li class="list-group-item">
                            {{ link_to_route("plant.show", $plant->name, $plant->id, ["class" => "pull-left" ]) }}
                            {{ Form::open(["route" => ["plant.destroy",  $plant->id], "method" => "DELETE"]) }}
                            {{ Form::submit("Delete", ["class" => "btn btn-danger btn-sm pull-right", "onClick" => 'return confirmDelete(this)', "data-name" => $plant->name]) }}
                            {{ Form::close() }}
                            <div class="clearfix"></div>
                        </li>
                    @endforeach
                    </ul>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

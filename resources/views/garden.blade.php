@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Garden
                @if ($garden->id != null)
                   - {{ $garden->name }}
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
                          {{ Form::model($garden, [
                                "route" => [$garden->id != null ? 'garden.update' : 'garden.store', $garden->id],
                                "method" => $garden->id != null ? "PUT" : "POST"
                               ])
                          }}
                          <div class="form-group">
                             {{ Form::label('name', 'Name') }}
                             {{ Form::text("name", null, ["class" => "form-control"]) }}
                          </div>
                          {{ Form::submit("Save", [ "class" => "btn btn-default"]) }}
                          {{ Form::close() }}
                       </div>
                    </div>

                    @if ($garden->id != null)
                    <div class="panel panel-default">
                       <div class="panel-heading">Devices</div>
                       <ul class="list-group">
                          @foreach ($garden->devices as $device)
                             <li class="list-group-item">
                                <a href="/device/{{ $device->id }}">
                                   {{ $device->name }}
                                </a>
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

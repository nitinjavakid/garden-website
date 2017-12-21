@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Device - {{ $device->name }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title pull-left">Plants</div>
                        {{ link_to_route('plant.create', "", ["device" => $device->id], [ "class" => "btn btn-primary btn-sm glyphicon glyphicon-plus pull-right"]) }}
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <ul class="list-group">
                    @foreach ($device->plants as $plant)
                        <li class="list-group-item">
                            <a href="/plant/{{ $plant->id }}">
                                {{ $plant->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

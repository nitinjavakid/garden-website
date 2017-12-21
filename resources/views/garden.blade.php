@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Garden - {{ $garden->name }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

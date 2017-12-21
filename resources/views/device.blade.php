@extends('layouts.app')

@section('content')

<script>
</script>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

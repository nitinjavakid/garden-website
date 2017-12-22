@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title pull-left">Gardens</div>
                    {{ link_to_route('garden.create', "New", [], [ "class" => "btn btn-primary btn-sm pull-right"]) }}
                    <div class="clearfix"></div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <ul class="list-group">
                    @foreach ($gardens as $garden)
                        <li class="list-group-item">
                            {{ link_to_route("garden.show", $garden->name, $garden->id, ["class" => "pull-left" ]) }}
                            {{ Form::open(["route" => ["garden.destroy",  $garden->id], "method" => "DELETE"]) }}
                            {{ Form::submit("Delete", ["class" => "btn btn-danger btn-sm pull-right", "onClick" => 'return confirmDelete(this)', "data-name" => $garden->name]) }}
                            {{ Form::close() }}
                            <div class="clearfix"></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

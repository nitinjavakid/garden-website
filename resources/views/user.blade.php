@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Profile
                @if ($user->id != null)
                - {{ $user->name }}
                @endif
            </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel panel-default">
                       <div class="panel-heading">Profile</div>
                       <div class="panel-body">
                          {{ Form::model($user, [
                                "route" => [$user->id != null ? 'user.update' : 'user.store', $user->id],
                                "method" => $user->id != null ? "PUT" : "POST"
                               ])
                          }}
                          <div class="form-group">
                             {{ Form::label('name', 'Name') }}
                             {{ Form::text("name", null, ["class" => "form-control"]) }}
                             {{ Form::label('timezone', 'Timezone') }}
                             {!! Timezone::selectForm($user->timezone, null, array('class' => 'form-control', 'name' => 'timezone')) !!}
                          </div>
                          {{ Form::submit("Save", [ "class" => "btn btn-default"]) }}
                          {{ Form::close() }}
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

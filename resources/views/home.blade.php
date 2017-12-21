@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Gardens</div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group">
                    @foreach ($gardens as $garden)
                        <li class="list-group-item">
                            <a href="/garden/{{ $garden->id }}">
                                {{ $garden->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
            </div>
        </div>
    </div>
</div>
@endsection

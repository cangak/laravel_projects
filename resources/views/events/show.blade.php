@extends('masterchurch')
@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="well">
                    <h2>{{ $event->title }}</h2>
                    <p>{{ $event->time }}</p>
                    <p>
                        {{ $event->description }}
                    </p>
                    <p>
                        {{ $event->church->name }}
                    </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-warning">
                	<div class="panel-heading">
                		<h3 class="panel-title">Other events</h3>
                	</div>
                	<div class="panel-body">
                        @if($events->count() > 0)
                            <div class="list-group">
                                @foreach($events as $event)
                                    <a href="{{ url('events/' . $event->id . '/' . $event->slug) }}" class="list-group-item active">
                                        <h4 class="list-group-item-heading">{{ str_limit($event->title, 30) }}</h4>
                                        <p class="list-group-item-text">
                                            {{ $event->time }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            No event
                        @endif
                	</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="well">
                    <h2>Other churches with similar events</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
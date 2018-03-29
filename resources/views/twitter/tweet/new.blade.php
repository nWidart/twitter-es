@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('tweet:store') }}" class="form" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea class="form-control" name="tweet" id="tweet" rows="3" maxlength="140"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Tweet!</button>
                        </form>
                    </div>
                </div>
                @foreach($tweets as $tweet)
                    <div class="card">
                        <div class="card-body">
                            <strong>{{ $tweet->author }} (<small>{{ \Carbon\Carbon::parse($tweet->tweeted_at)->diffForHumans() }}</small>)</strong>
                            <p>{{ $tweet->tweet }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

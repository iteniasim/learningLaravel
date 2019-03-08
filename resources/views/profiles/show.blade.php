@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="h1">{{ $profileUser->name }}</div> &nbsp Created &nbsp
                <div>{{ $profileUser->created_at->diffForHumans() }}</div>
            </div>

            <hr>

            @foreach ($threads as $thread)
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            {{ $thread->title }}
                        </div>
                        <div>
                            Posted by: <a href="{{ route('profile.show', $thread->owner) }}">{{ $thread->owner->name }}</a>
                            {{ $thread->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            @endforeach
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection

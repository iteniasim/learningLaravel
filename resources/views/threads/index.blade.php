@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse ($threads as $thread)
            <div class="pb-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="h5"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></div>
                            <a href="{{ $thread->path() }}">{{ $thread->replies_count }}
                                {{ str_plural('reply',$thread->replies_count) }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>{{ $thread->body }}</div>
                    </div>
                </div>
            </div>
            @empty
            Threa are no threads for this channel.
            @endforelse
        </div>
    </div>
</div>
@endsection

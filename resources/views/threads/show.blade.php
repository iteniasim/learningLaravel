@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="">
                        {{ $thread->owner->name }}
                    </a> posted:
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ $thread->body }}
                </div>
            </div>

            <br>

            @foreach ($replies as $reply)
            @include('threads.reply')
            <br>
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
            <div class="card p-2">
                <form action="{{ $thread->path(). '/replies' }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <lable for="body">Body:</lable>
                        <textarea name="body" id="body" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-group">
                            <button type="Submit" class="btn btn-primary">Publish</button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This Thread was published at {{ $thread->created_at->diffForHumans() }}
                    by
                    <a href="#">
                        {{ $thread->owner->name }}
                    </a>, and currently has {{ $thread->replies_count }}
                    {{ str_plural('comment',$thread->replies_count)}}.
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

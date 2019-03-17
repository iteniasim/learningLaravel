@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count={{ $thread->replies_count }} inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $thread->title }}
                            </div>
                            <div>
                                Posted by: <a href="{{ route('profile.show', $thread->owner) }}">{{
                                    $thread->owner->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>

                    @can('update', $thread)
                    <div class="d-flex justify-content-end pr-4">
                        <form method="POST" action="{{ $thread->path() }}">
                            @csrf
                            @method('DELETE')
                            <div class="form-group">
                                <button type="Submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                    @endcan
                </div>

                <br>

                <replies-component :data="{{ $thread->replies }}" @removed="repliesCount--"></replies-component>

                @if (auth()->check())
                <div class="card p-2">
                    <form action="{{ $thread->path(). '/replies' }}" method="POST">
                        @csrf
                        <div class="form-group">
                            Body:
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
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                    discussion.</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This Thread was published at {{ $thread->created_at->diffForHumans() }}
                        by
                        <a href="{{ route('profile.show', $thread->owner) }}">
                            {{ $thread->owner->name }}
                        </a>, and currently has <span v-text="repliesCount"></span>
                        {{ str_plural('comment',$thread->replies_count)}}.
                    </div>
                </div>
            </div>

        </div>
    </div>
</thread-view>
@endsection

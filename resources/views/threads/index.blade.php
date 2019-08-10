@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('threads._list')
            {{ $threads->render() }}
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form action="/threads/search" method="get">
                        <div class="form-group">
                            Search:
                            <input type="text" name="q" placeholder="Search something here...." class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="Submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <br>

            @if (count($trending))
            <div class="card">
                <div class="card-header">
                    Trending Threads
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($trending as $thread)
                        <li class="list-group-item">
                            <a href="{{ url($thread->path) }}">
                                {{ $thread->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

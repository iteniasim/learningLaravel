@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <div class="h1">
                    {{ $profileUser->name }}
                </div>

                @can('update', $profileUser)
                <form action="{{ route('avatar', $profileUser) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar">
                    <div class="form-group">
                        <button type="Submit" class="btn btn-primary">Add New Avatar</button>
                    </div>
                </form>
                @endcan
                <img src="{{ asset($profileUser->avatar_path) }}" width="50" height="50">
            </div>
            <hr>
            @forelse ($activities as $date => $activity)
            <div class="pb-2 mt-4 mb-2 border-bottom">
                {{ $date }}
            </div>
            @foreach ($activity as $record)
            @if (view()->exists("profiles.activities.{$record->type}"))
            @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endif
            @endforeach
            @empty
            There is no activity for this user yet.
            @endforelse
        </div>
    </div>
</div>
@endsection

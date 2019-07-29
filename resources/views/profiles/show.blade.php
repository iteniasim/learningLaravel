@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <img src="/{{ $profileUser->avatar_path }}" width="50" height="50" class="mr-1" />

                {{-- <avatar-form :user="{{ $profileUser }}"></avatar-form> --}}
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

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
            @forelse ($activities as $date => $activity)
            <div class="pb-2 mt-4 mb-2 border-bottom">
                {{ $date }}
            </div>
            @foreach ($activity as $record)
            @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endforeach
            @empty
            Threa are no threads by this User.
            @endforelse
            {{-- {{ $threads->links() }} --}}
        </div>
    </div>
</div>
@endsection

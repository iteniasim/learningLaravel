@component('profiles.activities.activity')

@slot('heading')
<div>
    <a href="{{ $activity->subject->favourited->path() }}">
        {{ $profileUser->name }}
        Favourited a reply.
    </a>
</div>
<div>
    {{ $activity->subject->created_at->diffForHumans() }}
</div>
@endslot

@slot('body')
{{ $activity->subject->favourited->body }}
@endslot

@endcomponent

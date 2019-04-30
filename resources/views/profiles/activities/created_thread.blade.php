@component('profiles.activities.activity')

@slot('heading')
<div>
    <a href="{{ route('profile', $activity->subject->owner) }}">
        {{ $activity->subject->owner->name }}
    </a>
    Published :
    <a href="{{ $activity->subject->path() }}">
        {{ $activity->subject->title }}
    </a>
</div>
<div>
    {{ $activity->subject->created_at->diffForHumans() }}
</div>
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot

@endcomponent

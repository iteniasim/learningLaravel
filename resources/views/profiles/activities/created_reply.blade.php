@component('profiles.activities.activity')

@slot('heading')
<div>
    <a href="{{ route('profile', $activity->subject->owner->name) }}">
        {{ $activity->subject->owner->name }}
    </a>
    Replied to :
    <a href="{{ $activity->subject->thread->path() }}">
        {{ $activity->subject->thread->title }}
    </a>
</div>
<div>
    {{ $activity->subject->created_at->diffForHumans() }}
</div>
@endslot

@slot('body')
{!! $activity->subject->body !!}
@endslot

@endcomponent

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('profile.show', $activity->subject->owner->name) }}">
                    {{ $activity->subject->owner->name }}
                </a>
                Replied to :
                <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
            </div>
            <div>
                {{ $activity->subject->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $activity->subject->body }}
    </div>
</div>

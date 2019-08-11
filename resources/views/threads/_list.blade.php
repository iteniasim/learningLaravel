@forelse ($threads as $thread)
<div class="pb-3">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <div class="h5">
                        <a href="{{ $thread->path() }}">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                {{ $thread->title }}
                            </strong>
                            @else
                            {{ $thread->title }}
                            @endif
                        </a>
                    </div>
                    <div>
                        Posted By:
                        <a href="{{ route('profile', $thread->owner) }}" class="text-decoration-none">
                            {{ $thread->owner->name }}
                        </a>
                    </div>
                </div>
                <div class="align-self-center">
                    <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }}
                        {{ str_plural('reply',$thread->replies_count) }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>{{ $thread->body }}</div>
        </div>
        <div class="card-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
</div>
@empty Threa are no threads for this channel. @endforelse

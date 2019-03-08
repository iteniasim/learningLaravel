<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('profile.show', $reply->owner) }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}...
            </div>
            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favourites">
                    @csrf
                    <button type="Submit" class="btn btn-primary" {{ $reply->isFavourited() ? 'disabled' : '' }}>
                        {{ $reply->favourites_count }} {{ str_plural('favorite',$reply->favourites_count) }}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        {{ $reply->body }}
    </div>
</div>

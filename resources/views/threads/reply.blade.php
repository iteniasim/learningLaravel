<reply-component :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}" class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> said
                    {{ $reply->created_at->diffForHumans() }}...
                </div>
                <div>
                    @if (Auth::check())
                    <favourite-component :reply="{{ $reply }}"></favourite-component>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
        <div class="card-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
            </div>
            <div>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
        </div>
        @endcan
    </div>
</reply-component>

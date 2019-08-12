@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('notice.index', auth()->user()) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="channel_id">To</label>
                    <select name="recipient_type" id="recipient_type" class="form-control" required>
                        <option value="0">Students</option>
                        <option value="1">Teachers</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="channel_id">of Channel</label>
                    <select name="channel_id" id="channel_id" class="form-control" required>
                        @foreach ($channels as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Title:
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    Body:
                    <textarea name="body" id="body" class="form-control" rows="5" required>{{ old('body') }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="form-group">
                        <button type="Submit" class="btn btn-primary">Publish</button>
                    </div>
                </div>

                @if (count($errors))
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

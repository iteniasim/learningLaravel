@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($notices as $notice)
            <div class="pb-3">
                <div class="card">
                    <div class="card-header">
                        {{ $notice->title }}
                    </div>
                    <div class="card-body">
                        {{ $notice->body }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

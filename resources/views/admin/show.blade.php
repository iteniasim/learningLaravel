@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body">
                    <table style="width:100%">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Block</th>
                            <th>Delete</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="/admin/users/{{ $user->id }}/type" method="post">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-link"
                                        type="submit">{{ $user->user_type?'Teacher':'Student' }}</button>
                                </form>
                            </td>
                            <td>
                                <form action="/admin/users/{{ $user->id }}" method="post">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-{{ $user->blocked?'secondary':'primary' }}"
                                        type="submit">{{ $user->blocked?'Unblock':'Block' }}</button>
                                </form>
                            </td>
                            <td>
                                <form action="/admin/users/{{ $user->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

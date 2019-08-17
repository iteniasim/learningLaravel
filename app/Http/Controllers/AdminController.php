<?php

namespace App\Http\Controllers;

use App\User;

class AdminController extends Controller
{
    public function show()
    {
        $users = User::orderBy('name')->get();
        return view('admin.show', compact('users'));
    }

    public function update($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->blocked) {
            $user->update(['blocked' => 1]);
        } else {
            $user->update(['blocked' => 0]);
        }

        return redirect()->route('admin');
    }

    public function type($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->user_type) {
            $user->update(['user_type' => 1]);
        } else {
            $user->update(['user_type' => 0]);
        }

        return redirect()->route('admin');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect()->route('admin');
    }
}

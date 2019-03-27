<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy($user, $notification)
    {
        auth()->user()->notifications()->findOrFail($notification)->markAsRead();
    }
}

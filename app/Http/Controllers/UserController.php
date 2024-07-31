<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.id', 'users.name', 'users.email')
            ->leftJoin('notification_user', function ($join) {
                $join->on('users.id', '=', 'notification_user.user_id')
                ->where('notification_user.is_read', false);
            })
            ->where('users.is_admin', false)
            ->selectRaw('COUNT(notification_user.id) as unread_notifications_count')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();
        return view('users.index', compact('users'));
    }
}

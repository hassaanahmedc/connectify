<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(['notifications' => Auth::user()->notifications]);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->noContent();
    }
}

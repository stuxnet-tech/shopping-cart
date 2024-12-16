<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImpersonationController extends Controller
{
    public function start(User $user)
    {
        session(['original_user_id' => Auth::id()]);

        session(['impersonate' => $user->id]);

        Auth::loginUsingId($user->id);

        return redirect()->route('dashboard')->with('success', "You are now impersonating {$user->name}.");
    }

    public function stop()
    {
        session()->forget('impersonate');

        Auth::loginUsingId(session('original_user_id'));
    
        session()->forget('original_user_id');
    
        return redirect()->route('dashboard')->with('success', 'Impersonation stopped. You are back as Super Admin.');
    }
}


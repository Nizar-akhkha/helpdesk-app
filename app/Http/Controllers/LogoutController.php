<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // clear session variables
        $request->session()->forget([
            'user_id',
            'user_name',
            'user_email',
            'role',
            'is_logged_in',
            'verify_email',
        ]);

        // invalidate the session completely
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth');
    }
}
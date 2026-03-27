<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            return redirect()->route('auth')->withErrors([
                'login' => 'Google login failed. Try again.',
            ]);
        }

        $email = $googleUser->getEmail();
        $name  = $googleUser->getName() ?: 'User';

        if (!$email) {
            return redirect()->route('auth')->withErrors([
                'login' => 'Google account has no email.',
            ]);
        }

        $user = User::where('email', $email)->first();

        // ✅ If user doesn't exist: create it
        if (!$user) {
            $user = User::create([
                'username' => $name,
                'email' => $email,
                'password' => Hash::make(str()->random(24)), // random, because login is via Google
                'role' => 'user',
                'status' => 'pending_admin', // ✅ admin approval needed
                'verification_code' => null,
                'code_expires_at' => null,
            ]);

            return redirect()->route('auth')->withErrors([
                'login' => 'Compte créé via Google. En attente de validation par l’administrateur.',
            ]);
        }

        // ✅ If user existed but was pending_email, Google is verified -> move to pending_admin
        if ($user->status === 'pending_email') {
            $user->update([
                'status' => 'pending_admin',
                'verification_code' => null,
                'code_expires_at' => null,
            ]);
        }

        // ✅ block if not active
        if ($user->status === 'pending_admin') {
            return redirect()->route('auth')->withErrors([
                'login' => ' en attente de validation par admin.',
            ]);
        }

        if ($user->status === 'rejected') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Votre compte a été refusé par l’administrateur.',
            ]);
        }

        if ($user->status !== 'active') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Impossible de se connecter avec ce compte.',
            ]);
        }

        // ✅ Login OK -> set session + redirect by role
        session([
            'user_id' => $user->id,
            'user_name' => $user->username,
            'user_email' => $user->email,
            'role' => $user->role,
            'is_logged_in' => true,
        ]);

        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'agent') return redirect()->route('agent.dashboard');

        return redirect()->route('dashboard');
    }
}
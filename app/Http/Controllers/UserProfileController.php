<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    private function ensureUser()
    {
        if (!session('is_logged_in') || session('role') !== 'user') {
            abort(403);
        }
    }

    public function show()
    {
        $this->ensureUser();

        $user = User::findOrFail(session('user_id'));

        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $this->ensureUser();

        $user = User::findOrFail(session('user_id'));

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',

            'type' => 'required|in:etudiant,prof,scolarite',

            'filiere' => 'nullable|string|max:120',
            'annee' => 'nullable|string|max:20',
            'departement' => 'nullable|string|max:120',

            'cin' => 'nullable|string|max:30',
            'cne' => 'nullable|string|max:30',
            'date_naissance' => 'nullable|date',

            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Enforce conditional fields
        if ($validated['type'] === 'etudiant') {
            // required for student
            if (empty($validated['filiere']) || empty($validated['annee'])) {
                return back()->withErrors([
                    'type' => 'Pour un étudiant: filière et année sont obligatoires.',
                ])->withInput();
            }
            $validated['departement'] = null;
        } elseif ($validated['type'] === 'prof') {
            // required for prof
            if (empty($validated['departement'])) {
                return back()->withErrors([
                    'type' => 'Pour un professeur: département est obligatoire.',
                ])->withInput();
            }
            $validated['filiere'] = null;
            $validated['annee'] = null;
        } else {
            // scolarite
            $validated['filiere'] = null;
            $validated['annee'] = null;
            $validated['departement'] = null;
        }

        // Avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // delete old avatar if exists
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $path = $file->store('avatars', 'public');
            $validated['avatar_path'] = $path;
        }

        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'type' => $validated['type'],

            'filiere' => $validated['filiere'] ?? null,
            'annee' => $validated['annee'] ?? null,
            'departement' => $validated['departement'] ?? null,

            'cin' => $validated['cin'] ?? null,
            'cne' => $validated['cne'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,

            'avatar_path' => $validated['avatar_path'] ?? $user->avatar_path,
        ]);

        // update session display name/email
        session([
            'user_name' => $user->username,
            'user_email' => $user->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil mis à jour avec succès.');
    }
}
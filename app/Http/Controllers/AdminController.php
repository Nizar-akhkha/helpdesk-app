<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    private function ensureAdmin()
    {
        if (!session('is_logged_in') || session('role') !== 'admin') {
            abort(403);
        }
    }

    public function dashboard()
    {
        $this->ensureAdmin();

        $pendingCount  = User::where('status', 'pending_admin')->count();
        $activeCount   = User::where('status', 'active')->count();
        $rejectedCount = User::where('status', 'rejected')->count();

        return view('admin.dashboard', compact('pendingCount', 'activeCount', 'rejectedCount'));
    }

    public function index()
    {
        $this->ensureAdmin();

        $pendingUsers = User::where('status', 'pending_admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.confirmations', compact('pendingUsers'));
    }

    public function accept($id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ($user->status === 'pending_admin') {
            $user->update(['status' => 'active']);
        }

        return redirect()->route('admin.confirmations')->with('success', 'Compte accepté avec succès.');
    }

    public function reject($id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ($user->status === 'pending_admin') {
            $user->update(['status' => 'rejected']);
        }

        return redirect()->route('admin.confirmations')->with('success', 'Compte refusé avec succès.');
    }
}
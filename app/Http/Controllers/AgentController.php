<?php

namespace App\Http\Controllers;

class AgentController extends Controller
{
    public function dashboard()
    {
        if (!session('is_logged_in') || session('role') !== 'agent') {
            abort(403);
        }

        return view('agent.dashboard');
    }
}
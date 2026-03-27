<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserTicketController extends Controller
{
    protected function currentUser()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return (object) [
            'username' => session('user_name', 'Utilisateur'),
            'email' => session('user_email', '-'),
            'avatar_path' => null,
            'phone' => null,
            'type' => null,
            'cin' => null,
            'cne' => null,
            'date_naissance' => null,
            'departement' => null,
            'filiere' => null,
            'annee' => null,
        ];
    }

    protected function mockTickets(): Collection
    {
        return collect([
            (object) [
                'id' => 1,
                'code' => 'TCK-2026-0001',
                'subject' => 'Problème de connexion à la plateforme',
                'category' => 'Compte',
                'priority' => 'high',
                'status' => 'open',
                'created_at' => '2026-03-20 10:30:00',
                'updated_at' => '2026-03-25 09:15:00',
            ],
            (object) [
                'id' => 2,
                'code' => 'TCK-2026-0002',
                'subject' => 'Demande de modification des informations',
                'category' => 'Profil',
                'priority' => 'medium',
                'status' => 'pending',
                'created_at' => '2026-03-18 14:20:00',
                'updated_at' => '2026-03-24 11:45:00',
            ],
            (object) [
                'id' => 3,
                'code' => 'TCK-2026-0003',
                'subject' => 'Erreur lors du téléchargement d’un fichier',
                'category' => 'Technique',
                'priority' => 'urgent',
                'status' => 'in_progress',
                'created_at' => '2026-03-16 08:10:00',
                'updated_at' => '2026-03-26 12:00:00',
            ],
            (object) [
                'id' => 4,
                'code' => 'TCK-2026-0004',
                'subject' => 'Demande d’assistance résolue',
                'category' => 'Support',
                'priority' => 'low',
                'status' => 'resolved',
                'created_at' => '2026-03-10 15:00:00',
                'updated_at' => '2026-03-15 16:30:00',
            ],
            (object) [
                'id' => 5,
                'code' => 'TCK-2026-0005',
                'subject' => 'Question sur le statut de la demande',
                'category' => 'Suivi',
                'priority' => 'medium',
                'status' => 'closed',
                'created_at' => '2026-03-05 09:00:00',
                'updated_at' => '2026-03-12 13:20:00',
            ],
        ]);
    }

    protected function categories(): array
    {
        return [
            'Compte',
            'Profil',
            'Technique',
            'Support',
            'Suivi',
            'Autre',
        ];
    }

    public function create()
    {
        $user = $this->currentUser();
        $categories = $this->categories();

        return view('user.tickets.create', compact('user', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'description' => ['required', 'string', 'min:10'],
        ], [
            'subject.required' => 'Le sujet est obligatoire.',
            'category.required' => 'La catégorie est obligatoire.',
            'priority.required' => 'La priorité est obligatoire.',
            'priority.in' => 'La priorité sélectionnée est invalide.',
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
        ]);

        /*
        |----------------------------------------------------------------------
        | Étape actuelle
        |----------------------------------------------------------------------
        | Ici on garde encore une version temporaire sans enregistrement
        | réel dans la base de données.
        | Quand tu seras prêt, on remplacera ce bloc par :
        |
        | Ticket::create([...]);
        |
        */

        return redirect()
            ->route('user.tickets.index')
            ->with('success', 'Le ticket a été créé avec succès.');
    }

    public function index()
    {
        $user = $this->currentUser();

        $tickets = $this->mockTickets()
            ->filter(fn ($ticket) => in_array($ticket->status, ['open', 'pending', 'in_progress']))
            ->values();

        $stats = [
            'open' => $tickets->where('status', 'open')->count(),
            'pending' => $tickets->where('status', 'pending')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'total' => $tickets->count(),
        ];

        return view('user.tickets.index', compact('user', 'tickets', 'stats'));
    }

    public function history()
    {
        $user = $this->currentUser();

        $tickets = $this->mockTickets()
            ->filter(fn ($ticket) => in_array($ticket->status, ['resolved', 'closed']))
            ->values();

        $stats = [
            'resolved' => $tickets->where('status', 'resolved')->count(),
            'closed' => $tickets->where('status', 'closed')->count(),
            'total' => $tickets->count(),
        ];

        return view('user.tickets.history', compact('user', 'tickets', 'stats'));
    }
}
@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<style>
    .profile-page {
        padding: 24px;
        background: #f8fafc;
        min-height: calc(100vh - 70px);
    }

    .profile-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .profile-header {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .profile-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #e0e7ff;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.15);
        background: #eef2ff;
        flex-shrink: 0;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-user-info h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
    }

    .profile-user-info p {
        margin: 0 0 12px;
        color: #64748b;
        font-size: 15px;
    }

    .profile-badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 13px;
        font-weight: 600;
    }

    .profile-header-right {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .profile-btn {
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .profile-btn-primary {
        background: #4f46e5;
        color: #ffffff;
    }

    .profile-btn-primary:hover {
        background: #4338ca;
    }

    .profile-btn-secondary {
        background: #e2e8f0;
        color: #334155;
    }

    .profile-btn-secondary:hover {
        background: #cbd5e1;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .profile-card h2 {
        margin: 0 0 20px;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .profile-info-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
    }

    .profile-info-item.full-width {
        grid-column: 1 / -1;
    }

    .profile-info-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .profile-info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        word-break: break-word;
    }

    .profile-side-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .profile-side-box:last-child {
        margin-bottom: 0;
    }

    .profile-side-box h3 {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    .profile-side-box p {
        margin: 0;
        font-size: 14px;
        line-height: 1.6;
        color: #64748b;
    }

    @media (max-width: 992px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-page {
            padding: 16px;
        }

        .profile-header,
        .profile-card {
            padding: 18px;
        }

        .profile-info-grid {
            grid-template-columns: 1fr;
        }

        .profile-user-info h1 {
            font-size: 23px;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
        }
    }
</style>
@php
    $user = auth()->user();
@endphp

<div class="profile-page">
    <div class="profile-container">

        <div class="profile-header">
            <div class="profile-header-left">
                <div class="profile-avatar">
                    <img src="{{ $user && $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=4f46e5&color=ffffff&size=200' }}"
                         alt="Profile Avatar">
                </div>

                <div class="profile-user-info">
                    <h1>{{ $user->name ?? 'Utilisateur' }}</h1>
                    <p>{{ $user->email ?? '-' }}</p>
                    <span class="profile-badge">{{ $user->type ?? 'Utilisateur' }}</span>
                </div>
            </div>

            <div class="profile-header-right">
                <a href="#" class="profile-btn profile-btn-primary">Modifier Profil</a>
                <a href="#" class="profile-btn profile-btn-secondary">Settings</a>
            </div>
        </div>

        <div class="profile-grid">
            <div class="profile-card">
                <h2>Informations personnelles</h2>

                <div class="profile-info-grid">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Nom complet</span>
                        <div class="profile-info-value">{{ $user->name ?? '-' }}</div>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">Email</span>
                        <div class="profile-info-value">{{ $user->email ?? '-' }}</div>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">Téléphone</span>
                        <div class="profile-info-value">{{ $user->phone ?? '-' }}</div>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">Type</span>
                        <div class="profile-info-value">{{ $user->type ?? '-' }}</div>
                    </div>

                    @if(($user->type ?? '') === 'etudiant' || ($user->type ?? '') === 'Étudiant' || ($user->type ?? '') === 'student')
                        <div class="profile-info-item">
                            <span class="profile-info-label">Filière</span>
                            <div class="profile-info-value">{{ $user->filiere ?? '-' }}</div>
                        </div>

                        <div class="profile-info-item">
                            <span class="profile-info-label">Année</span>
                            <div class="profile-info-value">{{ $user->annee ?? '-' }}</div>
                        </div>
                    @endif

                    <div class="profile-info-item">
                        <span class="profile-info-label">CIN</span>
                        <div class="profile-info-value">{{ $user->cin ?? '-' }}</div>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">CNE</span>
                        <div class="profile-info-value">{{ $user->cne ?? '-' }}</div>
                    </div>

                    <div class="profile-info-item full-width">
                        <span class="profile-info-label">Date de naissance</span>
                        <div class="profile-info-value">{{ $user->date_naissance ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <h2>À propos du compte</h2>

                <div class="profile-side-box">
                    <h3>Sécurité</h3>
                    <p>Le mot de passe se modifie depuis la page Settings.</p>
                </div>

                <div class="profile-side-box">
                    <h3>Compte utilisateur</h3>
                    <p>Cette page affiche les informations personnelles de l’utilisateur connecté.</p>
                </div>

                <div class="profile-side-box">
                    <h3>Type dynamique</h3>
                    <p>Les champs Filière et Année apparaissent seulement si le type est Étudiant.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@extends('user.layouts.tickets')

@section('title', 'Créer un ticket')
@section('topbar_title', 'Créer un ticket')
@section('top_button_text', 'Mes tickets')
@section('top_button_link', route('user.tickets.index'))

@section('content')
    <div class="page-card">
        <h1 class="page-title">Créer un nouveau ticket</h1>
        <p class="page-text">
            Remplissez ce formulaire pour envoyer une demande d’assistance.
        </p>
    </div>

    <div class="form-card">
        <form action="{{ route('user.tickets.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="subject">Sujet</label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        class="form-control"
                        value="{{ old('subject') }}"
                        placeholder="Entrez le sujet du ticket"
                    >
                    @error('subject')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Catégorie</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">Choisir une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="priority">Priorité</label>
                    <select id="priority" name="priority" class="form-control">
                        <option value="">Choisir une priorité</option>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Faible</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Élevée</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priority')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input
                        type="text"
                        id="email"
                        class="form-control"
                        value="{{ $user->email ?? session('user_email') }}"
                        readonly
                    >
                </div>

                <div class="form-group full">
                    <label class="form-label" for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        placeholder="Décrivez le problème en détail..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Créer le ticket</button>
                <a href="{{ route('user.tickets.index') }}" class="btn secondary">Mes tickets</a>
            </div>
        </form>
    </div>
@endsection
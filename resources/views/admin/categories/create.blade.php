@extends('layouts.admin')

@section('title', 'Créer une catégorie')
@section('page_title', 'Créer une catégorie')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-card">
        <div class="page-header">
            <h1 class="page-title">Nouvelle catégorie</h1>
            <a href="{{ route('admin.categories.index') }}" class="btn">Retour</a>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="form-grid">
            @csrf

            <div class="form-group">
                <label for="name">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.categories.index') }}" class="btn">Annuler</a>
            </div>
        </form>
    </div>
@endsection
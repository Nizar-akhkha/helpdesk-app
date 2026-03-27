@extends('layouts.admin')

@section('title', 'Modifier une catégorie')
@section('page_title', 'Modifier une catégorie')

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
            <h1 class="page-title">Modifier la catégorie</h1>
            <a href="{{ route('admin.categories.index') }}" class="btn">Retour</a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.categories.index') }}" class="btn">Annuler</a>
            </div>
        </form>
    </div>
@endsection
@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Plataforma de Recetas</h3></div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card app-card p-4">
            <h5>Compartir Nueva Receta</h5>
            <form action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <div class="mb-2"><label>Nombre del Plato</label><input type="text" name="title" class="form-control" required></div>
                <div class="mb-2"><label>Tipo de Comida</label>
                    <select name="meal_type" class="form-select">
                        <option>Desayuno</option><option>Almuerzo</option><option>Cena</option><option>Postre</option>
                    </select>
                </div>
                <div class="mb-2"><label>Ingredientes</label><textarea name="ingredients" rows="3" class="form-control" placeholder="Ej: Pollo, ajo, limón..." required></textarea></div>
                <div class="mb-3"><label>Preparación</label><textarea name="instructions" rows="4" class="form-control" required></textarea></div>
                <button class="btn btn-primary w-100">Publicar Receta</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <form method="GET" class="d-flex gap-2 mb-3">
            <input type="text" name="ingredient" value="{{ request('ingredient') }}" class="form-control" placeholder="Buscar por plato o ingrediente...">
            <select name="meal_type" class="form-select w-auto">
                <option value="">Todos los tipos</option>
                <option {{ request('meal_type')=='Desayuno'?'selected':'' }}>Desayuno</option>
                <option {{ request('meal_type')=='Almuerzo'?'selected':'' }}>Almuerzo</option>
                <option {{ request('meal_type')=='Cena'?'selected':'' }}>Cena</option>
                <option {{ request('meal_type')=='Postre'?'selected':'' }}>Postre</option>
            </select>
            <button class="btn btn-dark">Filtrar</button>
        </form>
        <div class="row g-3">
            @forelse($recipes as $rec)
                <div class="col-12">
                    <div class="card app-card p-4">
                        <div class="d-flex justify-content-between">
                            <h5>{{ $rec->title }} <span class="badge bg-success ms-2">{{ $rec->meal_type }}</span></h5>
                            <form action="{{ route('recipes.destroy', $rec) }}" method="POST">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                        <p class="mb-1"><strong>Ingredientes:</strong> {{ $rec->ingredients }}</p>
                        <p class="text-muted mb-0"><strong>Preparación:</strong> {{ $rec->instructions }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No hay recetas que coincidan con tu búsqueda.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
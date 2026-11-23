@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Gestor de Notas</h3></div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card app-card p-4">
            <h5>Nueva Nota</h5>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="mb-2"><label>Título</label><input type="text" name="title" class="form-control" required></div>
                <div class="mb-2"><label>Categoría</label>
                    <select name="category" class="form-select">
                        <option>Personal</option><option>Trabajo</option><option>Estudio</option><option>Ideas</option>
                    </select>
                </div>
                <div class="mb-3"><label>Contenido</label><textarea name="content" rows="5" class="form-control" required></textarea></div>
                <button class="btn btn-primary w-100">Guardar Nota</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <form method="GET" class="d-flex gap-2 mb-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por título o contenido...">
            <select name="category" class="form-select w-auto">
                <option value="">Todas las categorías</option>
                <option {{ request('category')=='Personal'?'selected':'' }}>Personal</option>
                <option {{ request('category')=='Trabajo'?'selected':'' }}>Trabajo</option>
                <option {{ request('category')=='Estudio'?'selected':'' }}>Estudio</option>
                <option {{ request('category')=='Ideas'?'selected':'' }}>Ideas</option>
            </select>
            <button class="btn btn-dark">Buscar</button>
        </form>
        <div class="row g-3">
            @forelse($notes as $note)
                <div class="col-md-6">
                    <div class="card app-card p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">{{ $note->category }}</span>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST">@csrf @method('DELETE')
                                <button class="btn btn-sm text-danger p-0"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                        <h6>{{ $note->title }}</h6>
                        <p class="text-muted small mb-0">{{ $note->content }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">No se encontraron notas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
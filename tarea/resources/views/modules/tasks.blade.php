@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Lista de Tareas</h3></div>
<div class="card app-card p-4">
    <form action="{{ route('tasks.store') }}" method="POST" class="d-flex gap-2 mb-4">
        @csrf
        <input type="text" name="title" class="form-control" placeholder="Escribe una nueva tarea..." required>
        <button class="btn btn-primary px-4">Agregar</button>
    </form>
    <ul class="list-group">
        @forelse($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                        <i class="bi {{ $task->is_completed ? 'bi-check-lg' : 'bi-circle' }}"></i>
                    </button>
                    <span class="{{ $task->is_completed ? 'text-decoration-line-through text-muted' : 'fw-semibold' }}">
                        {{ $task->title }}
                    </span>
                </form>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
            </li>
        @empty
            <li class="list-group-item text-center text-muted">No hay tareas pendientes.</li>
        @endforelse
    </ul>
</div>
@endsection
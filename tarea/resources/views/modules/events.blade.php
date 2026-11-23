@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Calendario de Eventos</h3></div>

@if($upcomingReminders->count())
    <div class="alert alert-warning">
        <strong><i class="bi bi-bell-fill"></i> Recordatorios próximos (48h):</strong>
        <ul class="mb-0 mt-1">
            @foreach($upcomingReminders as $rem)
                <li>{{ $rem->title }} — <strong>{{ \Carbon\Carbon::parse($rem->event_datetime)->format('d/m/Y H:i') }}</strong></li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-md-4">
        <div class="card app-card p-4">
            <h5>Agendar Evento</h5>
            <form action="{{ route('events.store') }}" method="POST">
                @csrf
                <div class="mb-2"><label>Título del Evento</label><input type="text" name="title" class="form-control" required></div>
                <div class="mb-2"><label>Fecha y Hora</label><input type="datetime-local" name="event_datetime" class="form-control" required></div>
                <div class="mb-2"><label>Detalles</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="reminder" id="remCheck" checked>
                    <label class="form-check-label" for="remCheck">Activar recordatorio</label>
                </div>
                <button class="btn btn-primary w-100">Agregar Evento</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card app-card p-4">
            <h5>Eventos Programados</h5>
            <table class="table align-middle mt-3">
                <thead><tr><th>Fecha / Hora</th><th>Evento</th><th>Recordatorio</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($events as $ev)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($ev->event_datetime)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $ev->title }}</strong><br><small class="text-muted">{{ $ev->notes }}</small></td>
                            <td>{!! $ev->reminder ? '<span class="badge bg-warning text-dark"><i class="bi bi-bell"></i> Activo</span>' : '<span class="badge bg-light text-muted">No</span>' !!}</td>
                            <td class="d-flex gap-1">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEv{{ $ev->id }}"><i class="bi bi-pencil"></i></button>
                                <form action="{{ route('events.destroy', $ev) }}" method="POST">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="editEv{{ $ev->id }}" tabindex="-1">
                            <div class="modal-dialog"><form class="modal-content" action="{{ route('events.update', $ev) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header"><h5 class="modal-title">Editar Evento</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <div class="mb-2"><label>Título</label><input type="text" name="title" value="{{ $ev->title }}" class="form-control" required></div>
                                    <div class="mb-2"><label>Fecha y Hora</label><input type="datetime-local" name="event_datetime" value="{{ \Carbon\Carbon::parse($ev->event_datetime)->format('Y-m-d\TH:i') }}" class="form-control" required></div>
                                    <div class="mb-2"><label>Detalles</label><textarea name="notes" class="form-control">{{ $ev->notes }}</textarea></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="reminder" {{ $ev->reminder ? 'checked' : '' }}><label class="form-check-label">Recordatorio</label></div>
                                </div>
                                <div class="modal-footer"><button class="btn btn-primary">Guardar Cambios</button></div>
                            </form></div>
                        </div>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">No hay eventos agendados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Sistema de Reservas</h3></div>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card app-card p-4">
            <h5>Consultar Disponibilidad</h5>
            <form method="GET" class="d-flex gap-2 mb-3">
                <input type="date" name="date" value="{{ $date }}" class="form-control">
                <button class="btn btn-secondary">Ver Horarios</button>
            </form>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reservation_date" value="{{ $date }}">
                <div class="mb-2"><label>Nombre del Cliente</label><input type="text" name="client_name" class="form-control" required></div>
                <div class="mb-2"><label>Servicio</label>
                    <select name="service" class="form-select">
                        <option>Consulta General</option><option>Asesoría Técnica</option><option>Corte / Estética</option><option>Mantenimiento</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="d-block mb-1">Horarios Disponibles para <strong>{{ $date }}</strong>:</label>
                    <div class="row g-2">
                        @foreach($slots as $slot)
                            @php $occupied = in_array($slot, $bookedSlots); @endphp
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="time_slot" id="slot_{{ $loop->index }}" value="{{ $slot }}" {{ $occupied ? 'disabled' : 'required' }}>
                                <label class="btn w-100 {{ $occupied ? 'btn-outline-danger text-decoration-line-through' : 'btn-outline-success' }}" for="slot_{{ $loop->index }}">
                                    {{ $slot }} {{ $occupied ? '(Ocupado)' : '' }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-primary w-100">Confirmar Reserva</button>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card app-card p-4">
            <h5>Reservas Confirmadas</h5>
            <table class="table mt-3">
                <thead><tr><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Servicio</th><th></th></tr></thead>
                <tbody>
                    @forelse($reservations as $res)
                        <tr>
                            <td>{{ $res->reservation_date }}</td>
                            <td><span class="badge bg-info text-dark">{{ $res->time_slot }}</span></td>
                            <td>{{ $res->client_name }}</td>
                            <td>{{ $res->service }}</td>
                            <td>
                                <form action="{{ route('reservations.destroy', $res) }}" method="POST">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No hay reservas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
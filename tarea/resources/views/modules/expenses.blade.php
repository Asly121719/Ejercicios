@extends('layouts.app')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h3>Gestor de Gastos</h3>
    <form method="GET" class="d-flex gap-2">
        <input type="month" name="month" value="{{ $month }}" class="form-control">
        <button class="btn btn-outline-primary">Filtrar</button>
    </form>
</div>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card app-card p-4 mb-4">
            <h5>Registrar Gasto</h5>
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="mb-2"><label>Descripción</label><input type="text" name="description" class="form-control" required></div>
                <div class="mb-2"><label>Monto ($)</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
                <div class="mb-2"><label>Categoría</label>
                    <select name="category" class="form-select">
                        <option>Alimentación</option><option>Transporte</option><option>Vivienda</option><option>Entretenimiento</option><option>Salud</option><option>Otros</option>
                    </select>
                </div>
                <div class="mb-3"><label>Fecha</label><input type="date" name="expense_date" value="{{ now()->toDateString() }}" class="form-control" required></div>
                <button class="btn btn-primary w-100">Guardar Gasto</button>
            </form>
        </div>
        <div class="card app-card p-4 bg-primary text-white">
            <h6>Total Gastado en {{ $month }}</h6>
            <h2>${{ number_format($totalMonth, 2) }}</h2>
            <hr>
            @foreach($byCategory as $cat => $sum)
                <div class="d-flex justify-content-between"><span>{{ $cat }}</span><strong>${{ number_format($sum, 2) }}</strong></div>
            @endforeach
        </div>
    </div>
    <div class="col-md-7">
        <div class="card app-card p-4">
            <h5>Historial de Gastos ({{ $month }})</h5>
            <table class="table table-hover mt-3">
                <thead><tr><th>Fecha</th><th>Descripción</th><th>Categoría</th><th>Monto</th><th></th></tr></thead>
                <tbody>
                    @forelse($expenses as $exp)
                        <tr>
                            <td>{{ $exp->expense_date }}</td>
                            <td>{{ $exp->description }}</td>
                            <td><span class="badge bg-secondary">{{ $exp->category }}</span></td>
                            <td class="fw-bold text-danger">${{ number_format($exp->amount, 2) }}</td>
                            <td>
                                <form action="{{ route('expenses.destroy', $exp) }}" method="POST">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Sin gastos registrados en este mes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
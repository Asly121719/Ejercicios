@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Calculadora de Propinas</h3></div>
<div class="row">
    <div class="col-md-6">
        <div class="card app-card p-4">
            <div class="mb-3">
                <label class="form-label fw-bold">Monto Total de la Cuenta ($)</label>
                <input type="number" id="billAmount" class="form-control form-control-lg" placeholder="0.00" step="0.01" min="0" oninput="calcTip()">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Porcentaje de Propina (%)</label>
                <div class="d-flex gap-2 mb-2">
                    <button type="button" class="btn btn-outline-primary flex-fill" onclick="setTip(10)">10%</button>
                    <button type="button" class="btn btn-outline-primary flex-fill" onclick="setTip(15)">15%</button>
                    <button type="button" class="btn btn-outline-primary flex-fill" onclick="setTip(20)">20%</button>
                </div>
                <input type="number" id="tipPercent" class="form-control" value="15" min="0" max="100" oninput="calcTip()">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Dividir entre personas</label>
                <input type="number" id="peopleCount" class="form-control" value="1" min="1" oninput="calcTip()">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card app-card p-4 bg-dark text-white h-100 justify-content-center">
            <div class="mb-3"><span class="text-secondary">Propina Total:</span><h2 class="text-info" id="tipTotal">$0.00</h2></div>
            <div class="mb-3"><span class="text-secondary">Total con Propina:</span><h2 class="text-success" id="grandTotal">$0.00</h2></div>
            <div><span class="text-secondary">Total por Persona:</span><h3 id="perPerson">$0.00</h3></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function setTip(p) { document.getElementById('tipPercent').value = p; calcTip(); }
function calcTip() {
    const bill = parseFloat(document.getElementById('billAmount').value) || 0;
    const pct = parseFloat(document.getElementById('tipPercent').value) || 0;
    const people = Math.max(1, parseInt(document.getElementById('peopleCount').value) || 1);
    const tip = bill * (pct / 100);
    const total = bill + tip;
    document.getElementById('tipTotal').innerText = '$' + tip.toFixed(2);
    document.getElementById('grandTotal').innerText = '$' + total.toFixed(2);
    document.getElementById('perPerson').innerText = '$' + (total / people).toFixed(2);
}
</script>
@endpush
@endsection
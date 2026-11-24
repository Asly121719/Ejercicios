@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Generador de Contraseñas Seguras</h3></div>
<div class="card app-card p-4 col-md-7">
    <div class="input-group mb-4">
        <input type="text" id="pwdOutput" class="form-control form-control-lg font-monospace bg-light" readonly>
        <button class="btn btn-dark" onclick="copyPwd()"><i class="bi bi-clipboard"></i> Copiar</button>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Longitud: <span id="lenVal" class="text-primary">16</span> caracteres</label>
        <input type="range" id="pwdLen" class="form-range" min="6" max="50" value="16" oninput="document.getElementById('lenVal').innerText=this.value; generatePwd();">
    </div>
    <div class="row g-2 mb-4">
        <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="incUpper" checked onchange="generatePwd()"><label class="form-check-label">Mayúsculas (A-Z)</label></div></div>
        <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="incLower" checked onchange="generatePwd()"><label class="form-check-label">Minúsculas (a-z)</label></div></div>
        <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="incNums" checked onchange="generatePwd()"><label class="form-check-label">Números (0-9)</label></div></div>
        <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="incSyms" checked onchange="generatePwd()"><label class="form-check-label">Símbolos (!@#$%^&*)</label></div></div>
    </div>
    <button class="btn btn-primary w-100" onclick="generatePwd()"><i class="bi bi-arrow-repeat"></i> Generar Nueva Contraseña</button>
</div>
@push('scripts')
<script>
function generatePwd() {
    const len = document.getElementById('pwdLen').value;
    let chars = '';
    if (document.getElementById('incUpper').checked) chars += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (document.getElementById('incLower').checked) chars += 'abcdefghijklmnopqrstuvwxyz';
    if (document.getElementById('incNums').checked) chars += '0123456789';
    if (document.getElementById('incSyms').checked) chars += '!@#$%^&*()_+-=[]{}|;:,.<>?';
    if (!chars) { document.getElementById('pwdOutput').value = 'Selecciona al menos 1 opción'; return; }
    let pwd = '';
    const array = new Uint32Array(len);
    window.crypto.getRandomValues(array);
    for (let i = 0; i < len; i++) pwd += chars[array[i] % chars.length];
    document.getElementById('pwdOutput').value = pwd;
}
function copyPwd() {
    const el = document.getElementById('pwdOutput');
    el.select(); navigator.clipboard.writeText(el.value);
    alert('Contraseña copiada al portapapeles');
}
generatePwd();
</script>
@endpush
@endsection
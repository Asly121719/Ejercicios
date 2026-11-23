@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Cronómetro Online</h3></div>
<div class="card app-card p-5 text-center col-md-7 mx-auto">
    <h1 class="display-2 font-monospace fw-bold my-4" id="display">00:00:00.00</h1>
    <div class="d-flex justify-content-center gap-3 mb-4">
        <button class="btn btn-success btn-lg px-4" onclick="startSW()"><i class="bi bi-play-fill"></i> Iniciar</button>
        <button class="btn btn-warning btn-lg px-4" onclick="pauseSW()"><i class="bi bi-pause-fill"></i> Pausar</button>
        <button class="btn btn-info btn-lg px-4 text-white" onclick="lapSW()"><i class="bi bi-flag-fill"></i> Vuelta</button>
        <button class="btn btn-danger btn-lg px-4" onclick="resetSW()"><i class="bi bi-arrow-counterclockwise"></i> Reiniciar</button>
    </div>
    <ul class="list-group text-start" id="lapsList"></ul>
</div>
@push('scripts')
<script>
let startTime = 0, elapsed = 0, timer = null, lapCount = 0;
function formatTime(ms) {
    let cs = Math.floor((ms % 1000) / 10);
    let s = Math.floor((ms / 1000) % 60);
    let m = Math.floor((ms / 60000) % 60);
    let h = Math.floor(ms / 3600000);
    return [h, m, s].map(v => String(v).padStart(2, '0')).join(':') + '.' + String(cs).padStart(2, '0');
}
function startSW() {
    if (timer) return;
    startTime = Date.now() - elapsed;
    timer = setInterval(() => {
        elapsed = Date.now() - startTime;
        document.getElementById('display').innerText = formatTime(elapsed);
    }, 10);
}
function pauseSW() { clearInterval(timer); timer = null; }
function resetSW() {
    pauseSW(); elapsed = 0; lapCount = 0;
    document.getElementById('display').innerText = '00:00:00.00';
    document.getElementById('lapsList').innerHTML = '';
}
function lapSW() {
    if (!elapsed) return;
    lapCount++;
    document.getElementById('lapsList').insertAdjacentHTML('afterbegin', `<li class="list-group-item d-flex justify-content-between"><span>Vuelta #${lapCount}</span><strong class="font-monospace">${formatTime(elapsed)}</strong></li>`);
}
</script>
@endpush
@endsection
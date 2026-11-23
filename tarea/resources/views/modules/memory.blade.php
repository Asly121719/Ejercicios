@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Juego de Memoria</h3></div>
<div class="row g-4">
    <div class="col-md-8">
        <div class="card app-card p-4">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <input type="text" id="playerName" class="form-control" placeholder="Tu nombre" value="Jugador 1">
                    <select id="difficulty" class="form-select" onchange="initGame()">
                        <option value="4">Fácil (4 pares)</option>
                        <option value="6" selected>Medio (6 pares)</option>
                        <option value="8">Difícil (8 pares)</option>
                    </select>
                </div>
                <div>
                    <span class="badge bg-dark fs-6 me-2">Movimientos: <span id="moves">0</span></span>
                    <button class="btn btn-primary" onclick="initGame()">Reiniciar</button>
                </div>
            </div>
            <div id="board" class="row g-2"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card app-card p-4">
            <h5>Mejores Puntajes (Menos movimientos)</h5>
            <ol class="list-group list-group-numbered mt-3">
                @foreach($scores as $s)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $s->player_name }} <small class="text-muted">({{ $s->difficulty }})</small></span>
                        <strong>{{ $s->moves }} mov.</strong>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
@push('scripts')
<script>
const icons = ['bi-rocket-takeoff','bi-heart-fill','bi-star-fill','bi-lightning-fill','bi-gem','bi-sun-fill','bi-moon-stars-fill','bi-trophy-fill'];
let flipped = [], matched = 0, moves = 0, totalPairs = 6, lock = false;

function initGame() {
    const diffSelect = document.getElementById('difficulty');
    totalPairs = parseInt(diffSelect.value);
    moves = 0; matched = 0; flipped = []; lock = false;
    document.getElementById('moves').innerText = 0;
    let deck = [...icons.slice(0, totalPairs), ...icons.slice(0, totalPairs)].sort(() => Math.random() - 0.5);
    const board = document.getElementById('board');
    board.innerHTML = '';
    deck.forEach((icon) => {
        board.innerHTML += `<div class="col-3"><button class="btn btn-outline-primary w-100 py-4 fs-2 card-btn" data-icon="${icon}" onclick="flipCard(this)"><i class="bi bi-question-lg"></i></button></div>`;
    });
}

function flipCard(btn) {
    if (lock || btn.classList.contains('matched') || flipped.includes(btn)) return;
    btn.innerHTML = `<i class="bi ${btn.dataset.icon}"></i>`;
    btn.classList.replace('btn-outline-primary', 'btn-primary');
    flipped.push(btn);

    if (flipped.length === 2) {
        moves++; document.getElementById('moves').innerText = moves;
        lock = true;
        if (flipped[0].dataset.icon === flipped[1].dataset.icon) {
            flipped.forEach(b => { b.classList.replace('btn-primary', 'btn-success'); b.classList.add('matched'); });
            matched++; flipped = []; lock = false;
            if (matched === totalPairs) saveScore();
        } else {
            setTimeout(() => {
                flipped.forEach(b => { b.innerHTML = '<i class="bi bi-question-lg"></i>'; b.classList.replace('btn-primary', 'btn-outline-primary'); });
                flipped = []; lock = false;
            }, 700);
        }
    }
}

function saveScore() {
    const diffText = document.getElementById('difficulty').selectedOptions[0].text;
    fetch('{{ route("memory.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({ player_name: document.getElementById('playerName').value || 'Anónimo', difficulty: diffText, moves: moves })
    }).then(() => { alert('¡Ganaste en ' + moves + ' movimientos!'); location.reload(); });
}
initGame();
</script>
@endpush
@endsection
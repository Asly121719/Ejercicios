@extends('layouts.app')
@section('content')
<div class="page-header"><h3>Plataforma de Encuestas</h3></div>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card app-card p-4">
            <h5>Crear Nueva Encuesta</h5>
            <form action="{{ route('polls.store') }}" method="POST">
                @csrf
                <div class="mb-3"><label>Pregunta</label><input type="text" name="question" class="form-control" required></div>
                <div id="optionsContainer">
                    <div class="mb-2"><input type="text" name="options[]" class="form-control" placeholder="Opción 1" required></div>
                    <div class="mb-2"><input type="text" name="options[]" class="form-control" placeholder="Opción 2" required></div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addOption()">+ Añadir otra opción</button>
                <button class="btn btn-primary w-100">Publicar Encuesta</button>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        @forelse($polls as $poll)
            @php $totalVotes = $poll->options->sum('votes'); @endphp
            <div class="card app-card p-4 mb-3">
                <div class="d-flex justify-content-between">
                    <h5>{{ $poll->question }}</h5>
                    <form action="{{ route('polls.destroy', $poll) }}" method="POST">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                <small class="text-muted mb-3">Total de votos: {{ $totalVotes }}</small>
                @foreach($poll->options as $opt)
                    @php $pct = $totalVotes > 0 ? round(($opt->votes / $totalVotes) * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ $opt->option_text }} ({{ $opt->votes }} votos - {{ $pct }}%)</span>
                            <form action="{{ route('polls.vote', $opt) }}" method="POST">@csrf
                                <button class="btn btn-sm btn-outline-primary">Votar</button>
                            </form>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-info" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-center text-muted">Aún no hay encuestas creadas.</p>
        @endforelse
    </div>
</div>
@push('scripts')
<script>
function addOption() {
    const count = document.querySelectorAll('#optionsContainer input').length + 1;
    document.getElementById('optionsContainer').insertAdjacentHTML('beforeend', `<div class="mb-2"><input type="text" name="options[]" class="form-control" placeholder="Opción ${count}" required></div>`);
}
</script>
@endpush
@endsection
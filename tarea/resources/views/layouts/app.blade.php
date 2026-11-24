<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ejercicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { width: 270px; min-height: 100vh; background: #1e293b; color: #fff; position: fixed; top: 0; left: 0; overflow-y: auto; }
        .sidebar .brand { padding: 1.25rem 1.5rem; font-size: 1.2rem; font-weight: 700; border-bottom: 1px solid #334155; color: #38bdf8; }
        .sidebar .nav-link { color: #cbd5e1; padding: 0.7rem 1.5rem; display: flex; align-items: center; gap: 10px; font-size: 0.92rem; transition: 0.2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #334155; color: #fff; border-left: 4px solid #38bdf8; }
        .main-content { margin-left: 270px; padding: 2rem; }
        .app-card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #fff; }
        .page-header { margin-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.75rem; }
        @media (max-width: 768px) {
            .sidebar { position: relative; width: 100%; min-height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand"><i class="bi bi-grid-1x2-fill"></i> Apps</div>
    <nav class="nav flex-column py-2">
        <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="bi bi-check2-square"></i> Lista de Tareas</a>
        <a class="nav-link {{ request()->routeIs('tips.*') ? 'active' : '' }}" href="{{ route('tips.index') }}"><i class="bi bi-calculator"></i> Calculadora de Propinas</a>
        <a class="nav-link {{ request()->routeIs('passwords.*') ? 'active' : '' }}" href="{{ route('passwords.index') }}"><i class="bi bi-shield-lock"></i> Generador de Contraseñas</a>
        <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}"><i class="bi bi-wallet2"></i> Gestor de Gastos</a>
        <a class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}" href="{{ route('reservations.index') }}"><i class="bi bi-calendar-check"></i> Sistema de Reservas</a>
        <a class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}" href="{{ route('notes.index') }}"><i class="bi bi-journal-text"></i> Gestor de Notas</a>
        <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}"><i class="bi bi-calendar-event"></i> Calendario de Eventos</a>
        <a class="nav-link {{ request()->routeIs('recipes.*') ? 'active' : '' }}" href="{{ route('recipes.index') }}"><i class="bi bi-book"></i> Plataforma de Recetas</a>
        <a class="nav-link {{ request()->routeIs('memory.*') ? 'active' : '' }}" href="{{ route('memory.index') }}"><i class="bi bi-controller"></i> Juego de Memoria</a>
        <a class="nav-link {{ request()->routeIs('polls.*') ? 'active' : '' }}" href="{{ route('polls.index') }}"><i class="bi bi-bar-chart"></i> Plataforma de Encuestas</a>
        <a class="nav-link {{ request()->routeIs('stopwatch.*') ? 'active' : '' }}" href="{{ route('stopwatch.index') }}"><i class="bi bi-stopwatch"></i> Cronómetro Online</a>
    </nav>
</aside>

<main class="main-content">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
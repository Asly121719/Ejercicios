<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('tasks.index'));

// 1. Lista de Tareas
Route::get('/tareas', [AppController::class, 'tasksIndex'])->name('tasks.index');
Route::post('/tareas', [AppController::class, 'tasksStore'])->name('tasks.store');
Route::patch('/tareas/{task}', [AppController::class, 'tasksToggle'])->name('tasks.toggle');
Route::delete('/tareas/{task}', [AppController::class, 'tasksDestroy'])->name('tasks.destroy');

// 2. Calculadora de Propinas
Route::get('/propinas', [AppController::class, 'tipsIndex'])->name('tips.index');

// 3. Generador de Contraseñas Seguras
Route::get('/contrasenas', [AppController::class, 'passwordsIndex'])->name('passwords.index');

// 4. Gestor de Gastos
Route::get('/gastos', [AppController::class, 'expensesIndex'])->name('expenses.index');
Route::post('/gastos', [AppController::class, 'expensesStore'])->name('expenses.store');
Route::delete('/gastos/{expense}', [AppController::class, 'expensesDestroy'])->name('expenses.destroy');

// 5. Sistema de Reservas
Route::get('/reservas', [AppController::class, 'reservationsIndex'])->name('reservations.index');
Route::post('/reservas', [AppController::class, 'reservationsStore'])->name('reservations.store');
Route::delete('/reservas/{reservation}', [AppController::class, 'reservationsDestroy'])->name('reservations.destroy');

// 6. Gestor de Notas
Route::get('/notas', [AppController::class, 'notesIndex'])->name('notes.index');
Route::post('/notas', [AppController::class, 'notesStore'])->name('notes.store');
Route::delete('/notas/{note}', [AppController::class, 'notesDestroy'])->name('notes.destroy');

// 7. Calendario de Eventos
Route::get('/eventos', [AppController::class, 'eventsIndex'])->name('events.index');
Route::post('/eventos', [AppController::class, 'eventsStore'])->name('events.store');
Route::put('/eventos/{event}', [AppController::class, 'eventsUpdate'])->name('events.update');
Route::delete('/eventos/{event}', [AppController::class, 'eventsDestroy'])->name('events.destroy');

// 8. Plataforma de Recetas
Route::get('/recetas', [AppController::class, 'recipesIndex'])->name('recipes.index');
Route::post('/recetas', [AppController::class, 'recipesStore'])->name('recipes.store');
Route::delete('/recetas/{recipe}', [AppController::class, 'recipesDestroy'])->name('recipes.destroy');

// 9. Juego de Memoria
Route::get('/memoria', [AppController::class, 'memoryIndex'])->name('memory.index');
Route::post('/memoria', [AppController::class, 'memoryStore'])->name('memory.store');

// 10. Plataforma de Encuestas
Route::get('/encuestas', [AppController::class, 'pollsIndex'])->name('polls.index');
Route::post('/encuestas', [AppController::class, 'pollsStore'])->name('polls.store');
Route::post('/encuestas/votar/{option}', [AppController::class, 'pollsVote'])->name('polls.vote');
Route::delete('/encuestas/{poll}', [AppController::class, 'pollsDestroy'])->name('polls.destroy');

// 11. Cronómetro Online
Route::get('/cronometro', [AppController::class, 'stopwatchIndex'])->name('stopwatch.index');
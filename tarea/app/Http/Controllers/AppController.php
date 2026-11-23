<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Expense;
use App\Models\GameScore;
use App\Models\Note;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Recipe;
use App\Models\Reservation;
use App\Models\Task;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function tasksIndex()
    {
        $tasks = Task::latest()->get();
        return view('modules.tasks', compact('tasks'));
    }

    public function tasksStore(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        Task::create(['title' => $request->title]);
        return back()->with('status', 'Tarea agregada.');
    }

    public function tasksToggle(Task $task)
    {
        $task->update(['is_completed' => ! $task->is_completed]);
        return back();
    }

    public function tasksDestroy(Task $task)
    {
        $task->delete();
        return back()->with('status', 'Tarea eliminada.');
    }

    public function tipsIndex()
    {
        return view('modules.tips');
    }

    public function passwordsIndex()
    {
        return view('modules.passwords');
    }

    public function expensesIndex(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $expenses = Expense::where('expense_date', 'like', "{$month}%")->latest('expense_date')->get();
        $totalMonth = $expenses->sum('amount');
        $byCategory = $expenses->groupBy('category')->map->sum('amount');
        return view('modules.expenses', compact('expenses', 'totalMonth', 'byCategory', 'month'));
    }

    public function expensesStore(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string',
            'expense_date' => 'required|date',
        ]);
        Expense::create($data);
        return back()->with('status', 'Gasto registrado.');
    }

    public function expensesDestroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('status', 'Gasto eliminado.');
    }

    public function reservationsIndex(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $slots = ['09:00 AM', '10:00 AM', '11:00 AM', '02:00 PM', '03:00 PM', '04:00 PM'];
        $bookedSlots = Reservation::where('reservation_date', $date)->pluck('time_slot')->toArray();
        $reservations = Reservation::latest('reservation_date')->get();
        return view('modules.reservations', compact('reservations', 'slots', 'bookedSlots', 'date'));
    }

    public function reservationsStore(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:150',
            'service' => 'required|string|max:150',
            'reservation_date' => 'required|date',
            'time_slot' => 'required|string',
        ]);
        $exists = Reservation::where('reservation_date', $data['reservation_date'])
            ->where('time_slot', $data['time_slot'])->exists();
        if ($exists) {
            return back()->withErrors(['slot' => 'Ese horario ya está reservado para esa fecha.']);
        }
        Reservation::create($data);
        return back()->with('status', 'Reserva confirmada exitosamente.');
    }

    public function reservationsDestroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('status', 'Reserva cancelada.');
    }

    public function notesIndex(Request $request)
    {
        $query = Note::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q->where('title', 'like', "%{$s}%")->orWhere('content', 'like', "%{$s}%"));
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $notes = $query->latest()->get();
        return view('modules.notes', compact('notes'));
    }

    public function notesStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
        ]);
        Note::create($data);
        return back()->with('status', 'Nota guardada.');
    }

    public function notesDestroy(Note $note)
    {
        $note->delete();
        return back()->with('status', 'Nota eliminada.');
    }

    public function eventsIndex()
    {
        $events = Event::orderBy('event_datetime')->get();
        $upcomingReminders = Event::where('reminder', true)
            ->where('event_datetime', '>=', now())
            ->where('event_datetime', '<=', now()->addDays(2))
            ->get();
        return view('modules.events', compact('events', 'upcomingReminders'));
    }

    public function eventsStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'event_datetime' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $data['reminder'] = $request->has('reminder');
        Event::create($data);
        return back()->with('status', 'Evento agregado al calendario.');
    }

    public function eventsUpdate(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'event_datetime' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $data['reminder'] = $request->has('reminder');
        $event->update($data);
        return back()->with('status', 'Evento actualizado.');
    }

    public function eventsDestroy(Event $event)
    {
        $event->delete();
        return back()->with('status', 'Evento eliminado.');
    }

    public function recipesIndex(Request $request)
    {
        $query = Recipe::query();
        if ($request->filled('meal_type')) {
            $query->where('meal_type', $request->meal_type);
        }
        if ($request->filled('ingredient')) {
            $ing = $request->ingredient;
            $query->where(fn ($q) => $q->where('ingredients', 'like', "%{$ing}%")->orWhere('title', 'like', "%{$ing}%"));
        }
        $recipes = $query->latest()->get();
        return view('modules.recipes', compact('recipes'));
    }

    public function recipesStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'meal_type' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
        ]);
        Recipe::create($data);
        return back()->with('status', 'Receta publicada y guardada.');
    }

    public function recipesDestroy(Recipe $recipe)
    {
        $recipe->delete();
        return back()->with('status', 'Receta eliminada.');
    }

    public function memoryIndex()
    {
        $scores = GameScore::orderBy('moves')->take(10)->get();
        return view('modules.memory', compact('scores'));
    }

    public function memoryStore(Request $request)
    {
        $data = $request->validate([
            'player_name' => 'required|string|max:100',
            'difficulty' => 'required|string',
            'moves' => 'required|integer|min:1',
        ]);
        GameScore::create($data);
        return response()->json(['ok' => true]);
    }

    public function pollsIndex()
    {
        $polls = Poll::with('options')->latest()->get();
        return view('modules.polls', compact('polls'));
    }

    public function pollsStore(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:150',
        ]);
        $poll = Poll::create(['question' => $request->question]);
        foreach ($request->options as $opt) {
            $poll->options()->create(['option_text' => $opt]);
        }
        return back()->with('status', 'Encuesta creada.');
    }

    public function pollsVote(PollOption $option)
    {
        $option->increment('votes');
        return back()->with('status', 'Voto registrado.');
    }

    public function pollsDestroy(Poll $poll)
    {
        $poll->delete();
        return back()->with('status', 'Encuesta eliminada.');
    }

    public function stopwatchIndex()
    {
        return view('modules.stopwatch');
    }
}
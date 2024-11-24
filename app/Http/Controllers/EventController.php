<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

public function store(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    // Validasi input
    $request->validate([
        'event_name' => 'required|string|max:255',
        'event_date' => 'required|date',
        'location' => 'required|string|max:255',
    ]);

    // Mengonversi event_date menjadi objek Carbon
    $eventDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->event_date);

    // Menyimpan data acara ke dalam database
    Event::create([
        'event_name' => $request->event_name,
        'event_date' => $eventDate,
        'location' => $request->location,
    ]);

    return redirect()->route('events.index')->with('success', 'Event created successfully.');
}

public function show($id)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    $event = Event::findOrFail($id);
    
    // Mengonversi event_date menjadi objek Carbon
    $event->event_date = Carbon::parse($event->event_date);
    
    return view('events.show', compact('event'));
}

    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $event = Event::findOrFail($id);
        
        // Pastikan event_date adalah objek Carbon
        $event->event_date = Carbon::parse($event->event_date);
    
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
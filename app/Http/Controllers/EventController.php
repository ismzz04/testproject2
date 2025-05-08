<?php

namespace App\Http\Controllers;

use App\Models\event;
use Illuminate\Http\Request;
use Inertia\Inertia;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
      
        return Inertia::render('Welcome', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateEvent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event= $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Event::create($event);
        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
          return Inertia::render('EditEvent', [
            'event' => $event, // Pasa el evento a la vista
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Event $event)
{
        return Inertia::render('EditEvent', [
            'event' => $event, // Pasa el evento a la vista
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $event->update($validated);
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
}
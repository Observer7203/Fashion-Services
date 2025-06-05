<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:events,slug',
            'subtitle' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'included' => 'nullable|array',
            'dates' => 'nullable|array',
            'media' => 'nullable|array',
            'faq' => 'nullable|array',
            'frequency' => 'nullable|string',
            'seasons' => 'nullable|array',
            'historical' => 'nullable|string',
            'format' => 'nullable|string',
            'participants' => 'nullable|array',
            'organizers' => 'nullable|array',
            'location' => 'nullable|string',
            'streams' => 'nullable|array',
            'tours_included' => 'nullable|array',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Мероприятие добавлено');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:events,slug,' . $event->id,
            'subtitle' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'included' => 'nullable|array',
            'dates' => 'nullable|array',
            'media' => 'nullable|array',
            'faq' => 'nullable|array',
            'frequency' => 'nullable|string',
            'seasons' => 'nullable|array',
            'historical' => 'nullable|string',
            'format' => 'nullable|string',
            'participants' => 'nullable|array',
            'organizers' => 'nullable|array',
            'location' => 'nullable|string',
            'streams' => 'nullable|array',
            'tours_included' => 'nullable|array',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Мероприятие обновлено');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Мероприятие удалено');
    }
}

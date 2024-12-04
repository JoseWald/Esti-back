<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
   
    public function index()
    {
        /*$events = Event::all(); 
        return response()->json($events);*/
        return response()->json(['message' => 'atteint']);
    }

    
    public function show($id)
    {
        $event = Event::findOrFail($id); 
        return response()->json($event); 
    }

   
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date_format:d-m-Y',
            'image' => 'required|image', 
        ]);

     
        $imagePath = $request->file('image')->store('images', 'public'); 

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'image' => $imagePath, 
        ]);

        
        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'image' => 'required|string',
        ]);

       
        $event = Event::findOrFail($id);

      
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'image' => $request->image, 
        ]);

        return response()->json($event); 
    }

 
    public function destroy($id)
    {
     
        $event = Event::findOrFail($id);
    
        $event->delete();

        return response()->json(null, 204); 
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
   
    public function index()
    {
        $events = Event::all(); 
        return response()->json($events);
    }

    
    public function show($id)
    {
        $event = Event::findOrFail($id); 
        if ($event->image) {
            $event->image = asset('storage/' . $event->image);  
        }
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


 
    public function destroy($id)
    {
     
        $event = Event::findOrFail($id);

        if ($event->image) {
            $imagePath = public_path('storage/' . $event->image);
    
            if (file_exists($imagePath)) {
              
                unlink($imagePath);
            } else {
              
                Log::error("Image not found: " . $imagePath);
            }
        }
        $event->delete();

        return response()->json(null, 204); 
    }
}

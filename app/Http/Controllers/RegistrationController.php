<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Store a newly created pre-registration in storage.
     */public function store(Request $request){
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg',
        'year' => 'required|string|max:2',
        'department' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'birth_place' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'nationality' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255',
        'father_name' => 'required|string|max:255',
        'father_job' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'mother_job' => 'required|string|max:255',
        'parent_contact' => 'required|string|max:15',
        'invoice_path' => 'required|file|mimes:pdf,jpg,png',
        'grade_sheet_path' => 'required|file|mimes:pdf,jpg,png',
        'state' => 'nullable|boolean',
    ]);

  
    $photoPath = $request->file('photo')->store('photos', 'public'); 
    $invoice_pathPath = $request->file('invoice_path')->store('invoice_paths', 'public');
    $gradeSheetPath = $request->file('grade_sheet_path')->store('grade_sheet_paths', 'public');


$registration = Registration::create([
    'photo_path' => $photoPath,
    'year' => $request->year,
    'department' => $request->department,
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'birth_date' => $request->birth_date,
    'birth_place' => $request->birth_place,
    'address' => $request->address,
    'nationality' => $request->nationality,
    'phone' => $request->phone,
    'email' => $request->email,
    'father_name' => $request->father_name,
    'father_job' => $request->father_job,
    'mother_name' => $request->mother_name,
    'mother_job' => $request->mother_job,
    'parent_contact' => $request->parent_contact,
    'invoice_path_path' => $invoice_pathPath,
    'grade_sheet_path_path' => $gradeSheetPath,
    'state' => false
]);
    return response()->json($registration, 201);
    }


    /**
     * Display a listing of pre-registrations.
     */
    public function index()
    {
        
        $registrations = Registration::all();

        foreach ($registrations as $registration) {
            if ($registration->photo_path) {
                $registration->photo_path = asset('storage/' . $registration->photo_path);
            }
        }
    
        return response()->json($registrations);
    }

    /**
     * Display the specified pre-registration.
     */
    public function show($id)
    {
        $Registration = Registration::findOrFail($id);

        
        if ($Registration->photo_path) {
            $Registration->photo_path = asset('storage/' . $Registration->photo_path);
        }
        if ($Registration->invoice_path) {
            $Registration->invoice_path = asset('storage/' . $Registration->invoice_path);
        }
        if ($Registration->grade_sheet_path) {
            $Registration->grade_sheet_path = asset('storage/' . $Registration->grade_sheet_path);
        }

        return response()->json($Registration);
    }

    /**
     * Delete a pre-registration.
     */
    public function destroy($id)
    {
        $Registration = Registration::findOrFail($id);

        if ($Registration->photo) {
            Storage::delete('public/' . $Registration->photo);
        }
        if ($Registration->invoice_path) {
            Storage::delete('public/' . $Registration->invoice_path);
        }
        if ($Registration->grade_sheet_path) {
            Storage::delete('public/' . $Registration->grade_sheet_path);
        }

       
        $Registration->delete();

        return response()->json(null, 204);
    }

    /**
     * Approve a pre-registration
     */
    public function approve($id){
        $Registration = Registration::findOrFail($id);
        $Registration->state = true;
        $Registration->save();
        return response()->json(null, 204);
    }
}

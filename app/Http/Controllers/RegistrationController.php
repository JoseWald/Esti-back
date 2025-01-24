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
        'invoice' => 'required|file|mimes:pdf,jpg,png',
        'grade_sheet' => 'required|file|mimes:pdf,jpg,png',
        'state' => 'nullable|boolean',
    ]);

  
    $photoPath = $request->file('photo')->store('photos', 'public'); 
    $invoicePath = $request->file('invoice')->store('invoices', 'public');
    $gradeSheetPath = $request->file('grade_sheet')->store('grade_sheets', 'public');


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
    'invoice_path' => $invoicePath,
    'grade_sheet_path' => $gradeSheetPath,
    'state' => false
]);
    return response()->json($registration, 201);
    }


    /**
     * Display a listing of pre-registrations.
     */
    public function index()
    {
        
        $Registrations = Registration::all();
        return response()->json($Registrations);
    }

    /**
     * Display the specified pre-registration.
     */
    public function show($id)
    {
        $Registration = Registration::findOrFail($id);

        
        if ($Registration->photo) {
            $Registration->photo = asset('storage/' . $Registration->photo);
        }
        if ($Registration->invoice) {
            $Registration->invoice = asset('storage/' . $Registration->invoice);
        }
        if ($Registration->grade_sheet) {
            $Registration->grade_sheet = asset('storage/' . $Registration->grade_sheet);
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
        if ($Registration->invoice) {
            Storage::delete('public/' . $Registration->invoice);
        }
        if ($Registration->grade_sheet) {
            Storage::delete('public/' . $Registration->grade_sheet);
        }

       
        $Registration->delete();

        return response()->json(null, 204);
    }
}

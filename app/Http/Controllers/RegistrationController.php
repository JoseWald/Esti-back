<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Store a newly created pre-registration in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'photo' => 'required|image',
            'year' => 'required|string|max:10',
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
        ]);

       
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->hasFile('invoice')) {
            $validatedData['invoice'] = $request->file('invoice')->store('invoices', 'public');
        }

        if ($request->hasFile('grade_sheet')) {
            $validatedData['grade_sheet'] = $request->file('grade_sheet')->store('grade_sheets', 'public');
        }

       
        $Registration = Registration::create($validatedData);

        return response()->json($Registration, 201);
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

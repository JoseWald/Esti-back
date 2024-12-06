<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminInfo extends Controller
{
    public function updateEmail(Request $request)
    {
        
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:admin,email', 
            'password' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

    
        $admin = Admin::first(); 

        if (!$admin) {
            return response()->json(['message' => "There's no amdin , you can only create one on tinker for security reason"], 404);
        }

     
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Password incorrect'], 401);
        }

        try {            
                $admin->email = $request->email;
                $admin->save();
    
                return response()->json([
                    'message' => 'Email updated successfully'
                ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error while trying to update the email'], 500);
        }
    }

    public function updatePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required', 
        'new_password' => 'required|confirmed', 
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

 
    $admin = Admin::first();

    if (!$admin) {
        return response()->json(['message' => "There's no admin, you can only create one using tinker for security reasons"], 404);
    }


    if (!Hash::check($request->current_password, $admin->password)) {
        return response()->json(['message' => 'Current password is incorrect'], 401);
    }

    try {
      
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error while trying to update the password'], 500);
    }
}

}

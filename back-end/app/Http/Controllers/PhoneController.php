<?php

namespace App\Http\Controllers;
use App\Models\PhoneContact;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function sendPhone(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|numeric'
        ]);

        $phoneNumber = $validatedData['phone_number'];
        $phone = new PhoneContact();
        $phone->phone_number = $phoneNumber;
        $phone->save();

        return response()->json(['message' => 'Номер телефона сохранен успешно']);
    }
}

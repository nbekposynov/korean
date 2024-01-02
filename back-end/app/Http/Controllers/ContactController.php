<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function show($city_id): JsonResponse
    {
        $contacts = Contact::where('city_id', $city_id)->get();
        return response()->json($contacts); 
    }
}

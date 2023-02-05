<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function profile(Doctor $doctor)
    {
        $doctor->views++;

        return response()->json([
            'doctor' => new DoctorResource($doctor),
        ]);
    }

    public function popular(Request $request)
    {
        $popular_doctors = Doctor::popular()->get();
        return response()->json([
            'popular_doctors' => $popular_doctors,
        ], 200);
    }

    public function availableslots(Request $request, Doctor $doctor)
    {
        $available_slots = $doctor->slots()->available()->get();
        return response()->json([
            'available_slots' => $available_slots,
        ], 200);
    }
}

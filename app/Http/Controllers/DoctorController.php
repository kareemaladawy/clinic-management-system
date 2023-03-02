<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DoctorController extends Controller
{
    public function show($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);

            $doctor->views++;
            $doctor->save();

            return response()->json([
                'doctor' => new DoctorResource($doctor),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'doctor not found.'
            ], 404);
        }
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

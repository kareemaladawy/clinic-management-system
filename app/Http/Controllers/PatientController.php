<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientProfileRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return response()->json([
                'patient' => new PatientResource($patient)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'patient not found.'
            ], 404);
        }
    }
}

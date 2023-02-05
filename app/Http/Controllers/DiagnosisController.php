<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiagnoseRequest;
use App\Http\Requests\StoreRecordRequest;
use App\Models\Diagnose;
use App\Models\Patient;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    public function show(Patient $patient)
    {
        $diagnosis = $patient->diagnosis()->get();
        return response()->json([
            'diagnosis' => $diagnosis
        ], 200);
    }

    public function store(StoreDiagnoseRequest $request, Patient $patient)
    {
        $request->validated();
        try {
            $diagnose = $patient->diagnosis()->create([
                'patient_id' => $patient->id,
                'doctor_id' => Auth::user()->id,
                'disease' => $request->disease,
                'state' => $request->state,
                'note' => $request->note
            ]);
            return response()->json([
                'message' => 'diagnose created.',
                'diagnose' => $diagnose
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'diagnose already exists.'
            ], 401);
        }
    }
}

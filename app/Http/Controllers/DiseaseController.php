<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiseaseRequest;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DiseaseController extends Controller
{

    public function index()
    {
        $diseases = Disease::all();
        return response()->json([
            'diseases' => $diseases
        ], 200);
    }

    public function store(StoreDiseaseRequest $request)
    {
        try {
            $disease = Disease::create($request->validated());
            return response()->json([
                'message' => 'disease created.',
                'disease' => $disease
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'disease already exists.'
            ], 401);
        }
    }
}

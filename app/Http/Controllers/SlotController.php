<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlotRequest;
use App\Http\Resources\SLotResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SlotController extends Controller
{
    protected $guard = 'doctor';

    public function index()
    {
        try {
            $slots = Auth::user()->slots()->get();
            return response()->json([
                'slots' => SLotResource::collection($slots)
            ], 200);
        } catch (\BadMethodCallException $e) {
            return response()->json([
                'message' => 'unauthorized.'
            ], 401);
        }
    }

    public function store(StoreSlotRequest $request)
    {
        try {
            $slot = Auth::user()->slots()->create($request->validated());
            return response()->json([
                'message' => 'slot created.',
                'slot' => new SLotResource($slot)
            ], 200);
        } catch (\BadMethodCallException $e) {
            return response()->json([
                'message' => 'unauthorized.'
            ], 401);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'slot already exists.'
            ], 401);
        }
    }
}

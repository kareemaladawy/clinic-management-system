<?php

namespace App\Http\Controllers\Auth\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginPatientRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('patient');
    }

    public function login(LoginPatientRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Credentials do not match'
            ], 401);
        }

        $patient = Patient::where('email', $request->email)
            ->first();

        $patient->tokens()->delete();

        return response()->json([
            'patient' => new PatientResource($patient),
            'token' => $patient->createToken('Token of ' . $patient->name)->plainTextToken,
        ], 200);
    }

    public function register(StorePatientRequest $request)
    {
        $request->validated();

        if ($request->hasFile('avatar')) {
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->storeAs('avatars/patients', $filename, 'public');
        }

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'avatar' => $filename ?: null
        ]);

        return response()->json([
            'patient' => new PatientResource($patient),
            'token' => $patient->createToken('Token of ' . $patient->name)->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out.'
        ], 200);
    }
}

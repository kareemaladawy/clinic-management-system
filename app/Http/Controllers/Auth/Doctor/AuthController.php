<?php

namespace App\Http\Controllers\Auth\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginDoctorRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Resources\DoctorResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use PhpParser\Comment\Doc;

class AuthController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('doctor');
    }

    public function login(LoginDoctorRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Credentials do not match'
            ], 401);
        }

        $doctor = Doctor::where('email', $request->email)
            ->first();

        $doctor->tokens()->delete();

        return response()->json([
            'doctor' => new DoctorResource($doctor),
            'token' => $doctor->createToken('Token of ' . $doctor->name)->plainTextToken,
        ], 200);
    }

    public function register(StoreDoctorRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->storeAs('avatars/doctors', $filename, 'public');
        }

        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'specialty' => $request->specialty,
            'description' => $request->description,
            'location' => $request->location,
            'avatar' => $filename ?: null
        ]);

        return response()->json([
            'doctor' => new DoctorResource($doctor),
            'token' => $doctor->createToken('Token of ' . $doctor->name)->plainTextToken
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

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->validated());

        return response()->json([
            'message' => 'Profile updated.'
        ], 200);
    }
}

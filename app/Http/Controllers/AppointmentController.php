<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appoinments\StoreAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'appointments' => Auth::user()->appointments->map(function ($appointment) {
                return new AppointmentResource($appointment);
            })
        ]);
    }

    public function show(Request $request, Appointment $appointment)
    {
        return response()->json([
            'appointment' => new AppointmentResource($appointment)
        ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        try {
            $appointment = Auth::user()->appointments()->create($request->validated());
            // $appointment->slot()->update(['state' => 'taken']);
            Slot::find($appointment->slot_id)->update(['state' => 'taken']);
            return response()->json([
                'message' => 'appointment created.',
                'appointment' => $appointment
            ], 200);
        } catch (\BadMethodCallException $e) {
            return response()->json([
                'message' => 'unauthorized.'
            ], 401);
        }
    }

    public function destroy(Request $request, int $appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        if ($appointment) {
            if ($this->isAuthorized($request, $appointment)) {
                $appointment->delete();
                return response()->json([
                    'message' => 'Appointment Deleted.'
                ], 200);
            }
            return response()->json([
                'message' => 'Not Authorized.'
            ], 401);
        }

        return response()->json([
            'message' => 'Appointment not found.'
        ], 404);
    }

    private function isAuthorized(Request $request = null, Appointment $appointment)
    {
        return $request->user()->id == $appointment->patient_id || $request->user()->id == $appointment->slot->doctor_id;
    }
}

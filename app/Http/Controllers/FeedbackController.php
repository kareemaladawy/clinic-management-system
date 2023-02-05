<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Feedbacks\StoreFeedbackRequest;
use App\Models\Feedback;
use BadMethodCallException;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request)
    {
        $request->validated();

        try {
            $feedback = Auth::user()->feedbacks()->create([
                'doctor_id' => $request->doctor_id,
                'body' => $request->body
            ]);
            return response()->json([
                'message' => 'feedback created.',
                'feedback' => $feedback
            ], 401);
        } catch (BadMethodCallException $e) {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    public function destroy(Request $request, int $feedback_id)
    {
        $feedback = Feedback::find($feedback_id);
        if ($feedback) {
            if ($this->isAuthorized($request, $feedback)) {
                $feedback->delete();
                return response()->json([
                    'message' => 'Feedback Deleted.'
                ], 200);
            }
            return response()->json([
                'message' => 'Not Authorized.'
            ], 401);
        }

        return response()->json([
            'message' => 'Feedback not found.'
        ], 404);
    }

    private function isAuthorized(Request $request = null, Feedback $feedback)
    {
        return $request->user()->id == $feedback->patient_id || $request->user()->id == $feedback->doctor_id;
    }
}

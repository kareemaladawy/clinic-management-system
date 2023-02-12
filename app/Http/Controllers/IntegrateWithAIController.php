<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntegrateWithAIRequest;
use Exception;
use Illuminate\Support\Facades\Http;

class IntegrateWithAIController extends Controller
{
    public function check(IntegrateWithAIRequest $request)
    {
        try {
            if ($request->disease_category == 'schizophrenia') {
                $response = Http::attach('attachment', $request->attachment)->post('http://167.172.234.138:80');
            }
            if ($response->getStatusCode() == 200) {
                return response()->json([
                    'message' => 'success',
                    'data' => $response->getBody()
                ], 200);
            }
            return response()->json([
                'message' => 'response was not successful. please try again.',
                'data' => null
            ], $response->getStatusCode());
        } catch (Exception $e) {
            return response()->json([
                'message' => 'could not send request. please make sure the requested server is up and running.',
                'data' => null
            ], 500);
        }
    }
}

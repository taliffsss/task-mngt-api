<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Set success response
     */
    protected function success(?string $message, mixed $data, $statusCode = 201, $withToken = true): JsonResponse
    {
        $payload = [
            'result' => [
                'success' => true,
                'message' => $message,
                'access_token' => null,
                'expires_in' => null,
                'data' => $data,
            ],
        ];

        // Refreshed token
        if ($withToken && time() >= auth()->payload()->get('auto_refresh')) {
            if (empty(auth()->user()->remember_token)) {
                $credentials = auth()->user();
                auth()->invalidate(true);  // force current token in blacklisted
                $newToken = auth()->login($credentials);
                $payload['result']['access_token'] = $newToken;
                $payload['result']['expires_in'] = (int) auth()->payload()->get('exp');
            } else {
                $payload['result'] = array_filter($payload['result']);
            }
        } else {
            $payload['result'] = array_filter($payload['result']);
        }

        return response()->json($payload, $statusCode);
    }

    /**
     * Set Error response
     */
    protected function error($message = 'Internal error', $statusCode = 500): JsonResponse
    {
        // reorganize array message
        if (!is_scalar($message)) {
            $message = array_map('current', $message);
        }
        return response()->json([
            'result' => [
                'success' => false,
                'message' => $message,
                'data' => null,
            ],
        ], $statusCode);
    }

    protected function sendMail(string $template, string $to, string $toName, string $subject, array $data)
    {

        return Mail::send($template, $data, function($msg) use ($to, $toName, $subject) {
            $msg->to($to, $toName)->subject($subject);
        });
    }
}

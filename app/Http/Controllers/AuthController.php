<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\APIResponseTrait;

class AuthController extends Controller
{
    use APIResponseTrait;
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => 'bail|required|string|exists:users,email',
            'password' => 'required|string',
            'remember_me' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->only('email', 'password');

        if ($request->remember_me) {
            $token = auth()->setTTL(env('JWT_REMEMBER_ME_TTL'))->attempt($credentials, $request->remember_me);

            if (empty($token)) {
                return $this->error('Invalid email or password', Response::HTTP_BAD_REQUEST);
            }
        } else {
            $token = auth()->attempt($credentials);
        }

        if (empty($token)) {
            return $this->error('Invalid email or password', Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (int)auth()->payload()->get('exp'),
        ];

        return $this->success("Welcome back!", $data, Response::HTTP_OK);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        User::where('user_id', auth()->user()->user_id)->update(['remember_token' => null]);
        auth()->logout(true);

        return response()->json([
            'result' => [
                'success' => true,
                'message' => 'Successfully logged out',
                'data' => null,
            ],
        ], Response::HTTP_OK);
    }
}

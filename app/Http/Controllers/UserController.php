<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => 'bail|required|string|email:rfc,dns|unique:users',
            'password' => [
                'bail',
                'string',
                'min:6',
                'same:cpassword',
                'regex:/^(?=.*[a-zA-Z0-9])(?=.*[^a-zA-Z0-9])/',
                'required_with:cpassword'
            ],
            'cpassword' => [
                'bail',
                'string',
                'min:6',
                'regex:/^(?=.*[a-zA-Z0-9])(?=.*[^a-zA-Z0-9])/',
                'required_with:password'
            ],
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $validated = $validator->validated();

        $data = User::create($validated);

        if (!empty($data)) {
            return $this->success('Successfully Created', null, Response::HTTP_CREATED, false);
        }

        return $this->error('Unable to create user', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $data = User::find($id);

        if (empty($data)) {
            return $this->error("Can't find data", Response::HTTP_BAD_REQUEST);
        }

        return $this->success('Successfully fetch', $data->toArray(), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
    }
}

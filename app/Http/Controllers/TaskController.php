<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TaskSearchRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskDestroyRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskSearchRequest $request): JsonResponse
    {
        return $this->service->getList($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request): JsonResponse
    {
        return $this->service->create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id): JsonResponse
    {
        return $this->service->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskDestroyRequest $request, int $id): JsonResponse
    {
        return $this->service->delete($id);
    }
}

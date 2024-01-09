<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\TaskStatusService;

class TaskStatusController extends Controller
{
    public function __construct(protected TaskStatusService $service)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->service->getList();
    }
}

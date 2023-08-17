<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $cacheKey = auth()->user()->user_id . '_status_' . ($request->get('search') ?? null);
        $data = Cache::get($cacheKey);

        if ($data === null) {
            $query = TaskStatus::query();

            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            }

            $perPage = $request->get('per_page', 20);
            $data = $query->paginate($perPage);

            Cache::put($cacheKey, $data, now()->addHour(1));
        }

        return $this->success('Fetch successfully',  $data, Response::HTTP_OK);
    }
}

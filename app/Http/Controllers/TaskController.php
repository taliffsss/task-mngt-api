<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $validated = $validator->validated();

        // adding caching if you want will comment for now
        // $cacheKey = auth()->user()->user_id . '_tasks_' . ($request->get('search') ?? null);
        // $data = Cache::get($cacheKey);

        // if ($data === null) {
            $query = Task::query();

            if (isset($validated['search'])) {
                $query->where('title', 'like', '%' . $request->get('search') . '%');
            }
            
            $orderDirection = $validated['sort'] ?? 'desc';
            $query->orderBy('ordering', $orderDirection);
            $perPage = $request->get('per_page', 20);
            $data = $query->paginate($perPage);

            // Cache::put($cacheKey, $data, now()->addHour(1));
        // }

        return $this->success('Fetch successfully',  $data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->json()->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'ordering' =>'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $validated = $validator->validated();

        $maxOrdering = Task::max('ordering');
        $ordering = ($maxOrdering ? $maxOrdering + 1 : 1);
        // validate if ordering is right
        if ($validated['ordering'] < $ordering) {
            $validated['ordering'] = $ordering;
        }

        $data = Task::create($validated);

        if (!empty($data)) {
            return $this->success('Successfully Created', $data->refresh(), Response::HTTP_CREATED);
        }

        return $this->error('Unable to create task', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        $validator = Validator::make(array_merge($request->json()->all(), ['id' => $id]), [
            'id' => 'bail|required|numeric|exists:tasks,id',
            'title' => 'bail|nullable|string',
            'task_status_id' => 'bail|required|numeric|exists:tasks_status,id',
            'description' => 'nullable|string',
            'ordering' =>'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $validated = $validator->safe()->except(['id']);

        $todo = Task::findOrFail($id);

        $todo->update($validated);

        if (empty($todo)) {
            return $this->error('Unable to update task', Response::HTTP_BAD_REQUEST);
        }

        return $this->success('Successfully update', $todo->refresh()->toArray(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'bail|required|numeric|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->messages(), Response::HTTP_BAD_REQUEST);
        }

        $todo = Task::findOrFail($id);

        $todo->delete();

        if (empty($todo)) {
            return $this->error('Unable to create todo', Response::HTTP_BAD_REQUEST);
        }

        return $this->success('Successfully delete', null, Response::HTTP_OK, false);
    }
}

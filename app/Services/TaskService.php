<?php

namespace App\Services;

use App\Traits\APIResponseTrait;
use Illuminate\Http\Response;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskService
{
    use APIResponseTrait;

    public function getList(array $params)
    {
        $query = Task::query();

        if (isset($params['search'])) {
            $query->where('title', 'like', '%' . request()->get('search') . '%');
        }
        
        $orderDirection = $params['sort'] ?? 'desc';
        $query->orderBy('ordering', $orderDirection);
        $perPage = request()->get('per_page', 20);
        $data = $query->paginate($perPage);

        return $this->success('Fetch successfully', TaskResource::collection($data), Response::HTTP_OK);
    }

    public function create(array $params)
    {
        $maxOrdering = Task::max('ordering');
        $params['created_by'] = auth()->user()->user_id;
        $ordering = ($maxOrdering ? $maxOrdering + 1 : 1);
        if ($params['ordering'] < $ordering) {
            $params['ordering'] = $ordering;
        }

        $data = Task::create($params);

        if (!empty($data)) {
            return $this->success('Successfully Created', $data->refresh(), Response::HTTP_CREATED);
        }

        return $this->error('Unable to create task', Response::HTTP_BAD_REQUEST);
    }

    public function update(array $params)
    {
        $params['updated_by'] = auth()->user()->user_id;
        $todo = Task::findOrFail($params['id']);

        $todo->update($params);

        if (empty($todo)) {
            return $this->error('Unable to update task', Response::HTTP_BAD_REQUEST);
        }

        return $this->success('Successfully update', $todo->refresh()->toArray(), Response::HTTP_OK);
    }

    public function delete(int $id)
    {
        $todo = Task::findOrFail($id);
        $todo->deleted_by = auth()->user()->user_id;
        $todo->save();

        $todo->delete();

        if (empty($todo)) {
            return $this->error('Unable to create todo', Response::HTTP_BAD_REQUEST);
        }

        return $this->success('Successfully delete', null, Response::HTTP_OK, false);
    }
}

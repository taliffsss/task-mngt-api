<?php

namespace App\Services;

use App\Traits\APIResponseTrait;
use Illuminate\Http\Response;
use App\Models\TaskStatus;
use App\Http\Resources\TaskStatusResource;

class TaskStatusService
{
    use APIResponseTrait;

    public function getList()
    {
        $query = TaskStatus::query();

        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request()->get('search') . '%');
        }

        $perPage = request()->get('per_page', 20);
        $data = $query->paginate($perPage);

        return $this->success('Fetch successfully',  TaskStatusResource::collection($data), Response::HTTP_OK);
    }
}

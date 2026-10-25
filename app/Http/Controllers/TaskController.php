<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\UpdateTaskStatusRequest;
use App\Http\Requests\Task\UpdateTaskPriorityRequest;
use App\Http\Requests\Task\ReorderTasksRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = $this->service->all($request->only(['status', 'priority', 'search', 'page', 'per_page']));
        $tasks = $result['tasks'];

        return response()->json([
            'data' => TaskResource::collection($tasks->getCollection())->toArray($request),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
                'counts' => $result['counts'],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $this->service->store($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to store task data.'),
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = $this->service->getById($id);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        try {
            $task = $this->service->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully.',
                'data' => new TaskResource($task),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update task data.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->service->destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete task data.'),
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function updateStatus(UpdateTaskStatusRequest $request, $id)
    {
        $this->service->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully.',
        ]);
    }

    public function updatePriority(UpdateTaskPriorityRequest $request, $id)
    {
        $this->service->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task priority updated successfully.',
        ]);
    }

    public function reorder(ReorderTasksRequest $request)
    {
        $this->service->reorder($request->validated()['tasks']);

        return response()->json([
            'success' => true,
            'message' => 'Tasks reordered successfully.',
        ]);
    }
}

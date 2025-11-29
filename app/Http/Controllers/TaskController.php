<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = TaskResource::collection($this->service->all($request->all()));

        return response()->json($data);
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

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => ['required', new Enum(TaskStatus::class)],
        ]);

        Task::where('id', $id)->update([
            'status' => $data['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully.',
        ]);
    }
}

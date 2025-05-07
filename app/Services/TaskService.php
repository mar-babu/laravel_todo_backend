<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function all(array $filters = [])
    {
        $query = Task::where('user_id', auth()->id());

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getById(int $id)
    {
        return Task::where('user_id', auth()->id())->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->save($data);
    }

    public function update(int $id, array $data)
    {
        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        if (!auth()->check()) {
            abort(401, 'Unauthenticated');
        }

        $task = Task::findOrNew($id);
        $data['user_id'] = auth()->id();
        $task->fill($data);
        $task->save();

        return $task;
    }

    public function destroy(int $id): void
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        if (!$task) {
            abort(404, 'Not found');
        }

        $task->delete();
    }
}

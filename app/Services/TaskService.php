<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function all(array $filters = [])
    {
        $query = Task::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getById(int $id)
    {
        return Task::find($id);
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
        $task = Task::findOrNew($id);
        $task->fill($data);
        $task->save();

        return $task;
    }

    public function destroy(int $id): void
    {
        $task = Task::findOrFail($id);

        $task->delete();
    }
}

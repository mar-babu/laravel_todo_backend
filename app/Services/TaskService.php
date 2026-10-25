<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;

class TaskService
{
    private const DEFAULT_PER_PAGE = 15;

    private const MAX_PER_PAGE = 100;

    public function all(array $filters = []): array
    {
        $userId = auth()->id();

        $query = Task::where('user_id', $userId);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $perPage = min((int) ($filters['per_page'] ?? self::DEFAULT_PER_PAGE), self::MAX_PER_PAGE);
        $perPage = $perPage > 0 ? $perPage : self::DEFAULT_PER_PAGE;

        $tasks = $query
            ->orderBy('position', 'asc')
            ->orderBy('priority', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return [
            'tasks' => $tasks,
            'counts' => $this->counts($userId),
        ];
    }

    private function counts(int $userId): array
    {
        $counts = Task::where('user_id', $userId)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $byStatus = [];
        foreach (TaskStatus::cases() as $status) {
            $byStatus[$status->value] = (int) ($counts[$status->value] ?? 0);
        }

        return [
            'all' => array_sum($byStatus),
            ...$byStatus,
        ];
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

    public function reorder(array $tasks): void
    {
        $userId = auth()->id();
        foreach ($tasks as $taskData) {
            Task::where('id', $taskData['id'])
                ->where('user_id', $userId)
                ->update(['position' => $taskData['position']]);
        }
    }

    private function save(array $data, ?int $id = null)
    {
        if (! auth()->check()) {
            abort(401, 'Unauthenticated');
        }

        if ($id) {
            $task = Task::where('user_id', auth()->id())->findOrFail($id);
        } else {
            $task = new Task();
            $data['user_id'] = auth()->id();
        }

        $task->fill($data);
        $task->save();

        return $task;
    }

    public function destroy(int $id): void
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        if (! $task) {
            abort(404, 'Not found');
        }

        $task->delete();
    }
}

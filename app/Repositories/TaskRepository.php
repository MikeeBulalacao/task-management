<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Pagination\Paginator;

class TaskRepository
{
    private const DEFAULT_ORDER = 'created_at';
    private const DEFAULT_ORDER_DIR = 'desc';

    /**
     * Task $task
     */
    private Task $task;

    /**
     * TaskRepository constructor method
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Handles creating a task model
     */
    public function create(array $payload): Task
    {
        return $this->task->create($payload);
    }

    public function update(string $id, array $payload): int
    {
        return $this->task
            ->where('id', $id)
            ->update($payload);
    }

    public function list(array $filters, array $pagination): Paginator
    {
        return $this->task
            ->select('id', 'title', 'content')
            ->ownTask($filters['user_id'])
            ->status($filters['status'] ?? null)
            ->when(!empty($filters['search']), fn ($query) => (
                $query->where('title', 'LIKE', '%' . $filters['search'] . '%')
            ))
            ->orderBy(
                $filters['order_by'] ?? self::DEFAULT_ORDER,
                $filters['order_dir'] ?? self::DEFAULT_ORDER_DIR
            )
            ->simplePaginate(
                $pagination['per_page'] ?? 100,
                [],
                'page',
                $pagination['page'] ?? 1
            );
    }
}

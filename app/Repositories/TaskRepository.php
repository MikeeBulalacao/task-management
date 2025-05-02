<?php

namespace App\Repositories;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class TaskRepository
{
    /**
     * @var string
     */
    private const DEFAULT_ORDER = 'created_at';
    
    /**
     * @var string
     */
    private const DEFAULT_ORDER_DIR = 'desc';

    /**
     * @var Task $task
     */
    private Task $task;

    /**
     * TaskRepository constructor method
     * 
     * @param Task $task
     * 
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Handles creating a task model
     * 
     * @param array $payload
     * 
     * @return Task
     */
    public function create(array $payload): Task
    {
        return $this->task->create($payload);
    }

    /**
     * Handles updating a task one at a time
     *
     * @param string $id
     * @param array $payload
     * 
     * @return int
     */
    public function update(string $id, array $payload): int
    {
        return $this->task
            ->where('id', $id)
            ->update($payload);
    }

    /**
     * Handles deleting task depending on the condition provided
     * 
     * @param array $filters
     * 
     * @return int
     */
    public function delete(array $filters): int
    {
        return $this->task
            ->when(!empty($filters['id']), fn ($query) => (
                $query->where('id', $filters['id'])
            ))
            ->when(!empty($filters['days_past']), fn ($query) => (
                $query->where(
                    'created_at',
                    '<',
                    Carbon::now()->subDays($filters['days_past'])
                )
            ))
            ->delete();
    }

    /**
     * Handles listing all of the tasks
     *
     * @param array $filters
     * @param array $pagination
     * 
     * @return Paginator
     */
    public function list(array $filters, array $pagination): Paginator
    {
        return $this->task
            ->select(
                'id',
                'title',
                'content',
                'status',
                'published',
                'attachment'
            )
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

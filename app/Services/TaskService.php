<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Pagination\Paginator;

class TaskService
{
    /**
     * TaskRepository $taskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * TaskService constructor method
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Handles creating a task
     */
    public function create(array $payload): Task
    {
        return $this->taskRepository->create($payload);
    }

    public function update(string $id, array $payload): int
    {
        return $this->taskRepository->update($id, $payload);
    }

    public function list(array $filters, array $pagination): Paginator
    {
        return $this->taskRepository->list($filters, $pagination);
    }
}

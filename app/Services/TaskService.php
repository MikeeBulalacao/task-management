<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    /**
     * @var TaskRepository $taskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * TaskService constructor method
     * 
     * @param TaskRepository $taskRepository
     * 
     * @return void
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Handles creating a task
     * 
     * @param array $payload
     * 
     * @return Task
     */
    public function create(array $payload): Task
    {
        if (!empty($payload['attachment'])) {
            $payload = $this->storeAttachment($payload);
        }

        return $this->taskRepository->create($payload);
    }

    /**
     * Handles updating a task
     *
     * @param string $id
     * @param array $payload
     * 
     * @return int
     */
    public function update(string $id, array $payload): int
    {
        return $this->taskRepository->update($id, $payload);
    }

    /**
     * Handles listing all of the tasks
     * 
     * @param array $filters
     * @param array $pagination
     * 
     * @return LengthAwarePaginator
     */
    public function list(array $filters, array $pagination): LengthAwarePaginator
    {
        return $this->taskRepository->list($filters, $pagination);
    }

    /**
     * Handles deleting tasks
     *
     * @param array $filters
     * 
     * @return int
     */
    public function delete(array $filters): int
    {
        // Do not allow to delete if no filters are given
        if (empty($filters)) {
            return false;
        }

        return $this->taskRepository->delete($filters);
    }

    /**
     * Handles storing attachment in the local storage
     * 
     * @param array $payload
     * 
     * @return array
     */
    private function storeAttachment(array $payload)
    {
        $payload['attachment'] = $payload['attachment']->store('attachments');

        return $payload;
    }
}

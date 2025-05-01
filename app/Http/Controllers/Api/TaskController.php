<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskCreateRequest;
use App\Http\Requests\Api\TaskDeleteRequest;
use App\Http\Requests\Api\TaskListRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * TaskService $taskService
     */
    private TaskService $taskService;

    /**
     * TaskController constructor method
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display the user's profile form.
     */
    public function create(TaskCreateRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $task = $this->taskService->create($payload);

        return $this->response(
            new TaskResource($task),
            'Successfully created task.',
            Response::HTTP_CREATED,
        );
    }

    public function update(TaskUpdateRequest $request): JsonResponse
    {
        $payload = $request->validated();
        unset($payload['id']);

        $task = $this->taskService->update(
            $request->get('id'),
            $payload
        );

        return $this->response(
            new TaskResource($task),
            'Successfully created task.',
            Response::HTTP_CREATED,
        );
    }

    public function list(TaskListRequest $request): AnonymousResourceCollection
    {
        $filters = $request->validated();
        $pagination = $request->pagination();

        $list = $this->taskService->list(
            $filters,
            $pagination
        );

        return TaskResource::collection($list);
    }

    public function delete(TaskDeleteRequest $request): JsonResponse
    {
        $this->taskService->delete([
            'id' => $request->get('id')
        ]);

        return $this->response(
            (object) [],
            'Successfully deleted task.',
            Response::HTTP_NO_CONTENT,
        );
    }

    /**
     * In charge of returning the JsonResponse
     */
    private function response(
        object $resource,
        string $message = 'Success',
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $resource,
        ]);
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TaskListRequest extends FormRequest
{
    /**
     * @var array
     */
    private const ORDER_BY = [
        'title',
        'created_at',
    ];

    /**
     * @var array
     */
    private const ORDER_DIR = [
        'asc',
        'desc',
    ];

    /**
     * @var array
     */
    private const STATUSES = [
        'to-do',
        'in-progress',
        'done',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'status' => 'sometimes|required|in:' . implode(',', self::STATUSES),
            'search' => 'nullable',
            'order_by' => 'sometimes|required|in:' . implode(',', self::ORDER_BY),
            'order_dir' => 'sometimes|required|in:' . implode(',', self::ORDER_DIR),
        ];
    }

    /**
     * Return the pagination data
     * 
     * @return array
     */
    public function pagination()
    {
        return [
            'per_page' => $this->get('per_page', 100),
            'page' => $this->get('page', 1),
        ];
    }
}

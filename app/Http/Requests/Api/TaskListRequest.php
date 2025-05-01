<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskListRequest extends FormRequest
{
    private const ORDER_BY = [
        'title',
        'created_at',
    ];

    private const ORDER_DIR = [
        'asc',
        'desc',
    ];

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
            'search' => 'sometimes|required|string',
            'order_by' => 'sometimes|required|in:' . implode(',', self::ORDER_BY),
            'order_dir' => 'sometimes|required|in:' . implode(',', self::ORDER_DIR),
        ];
    }

    public function pagination()
    {
        return [
            'per_page' => 100,
            'page' => 1,
        ];
    }
}

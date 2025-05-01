<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends FormRequest
{
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
            'title' => 'required|max:100|unique:tasks',
            'content' => 'required|max:255',
            'status' => 'required|in:' . implode(',', self::STATUSES),
            'attachment' => 'sometimes|required',
        ];
    }
}

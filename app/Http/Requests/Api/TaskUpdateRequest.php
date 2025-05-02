<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
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
        $taskId = $this->route('id');

        return [
            'id' => 'required|exists:tasks,id,deleted_at,NULL,user_id,' . $this->user()->id,
            'title' => 'sometimes|required|max:100|unique:tasks,id,' . $taskId,
            'content' => 'sometimes|required|max:255',
            'status' => 'sometimes|required|in:' . implode(',', self::STATUSES),
            'published' => 'sometimes|required|boolean',
            'attachment' => 'sometimes|required',
        ];
    }

    /**
     * Merge the needed parameters before validating
     * 
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }
}

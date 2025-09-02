<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $course = $this->route('course');
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses')->ignore($course->id),
            ],
            'description' => ['nullable', 'string'],
            'lecturer_id' => ['required', 'exists:users,id']
        ];
    }
}

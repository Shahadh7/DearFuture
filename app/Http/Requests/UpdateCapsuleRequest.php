<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCapsuleRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'recipient_email' => ['nullable', 'email', 'max:255'],
            'unlock_date' => ['required', 'date', 'after:now'],
            'status' => ['required', Rule::in(['draft', 'locked'])],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt,wav,mp3', 'max:102400'],
        ];
    }
}

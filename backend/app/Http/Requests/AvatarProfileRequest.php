<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'max:2048'],
        ];
    }
}

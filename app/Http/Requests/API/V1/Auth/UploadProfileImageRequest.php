<?php

namespace App\Http\Requests\API\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\API\Traits\APIResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadProfileImageRequest extends FormRequest
{
    use APIResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(422, "Validation Errors", $validator->errors()));
    }
}

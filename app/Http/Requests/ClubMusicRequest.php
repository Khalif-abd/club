<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClubMusicRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'music_id' => ['required', 'integer', 'exists:App\Models\Music,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'music_id.required' => 'Не указан ID музыки.',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()->all()
            ], 400)
        );
    }


}

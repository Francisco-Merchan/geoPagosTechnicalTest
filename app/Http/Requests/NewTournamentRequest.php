<?php

namespace App\Http\Requests;

use App\Http\Resources\ValidationErrorsResource;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\PowerOfTwoRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewTournamentRequest extends FormRequest
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
            'name' => 'required|max:50',
            'female' => 'required|boolean',
            'participants' => ['required', 'array', new PowerOfTwoRule],
            'participants.*.name' => 'required|string|max:20',
            'participants.*.lastname' => 'required|string|max:20',
            'participants.*.age' => 'required|integer|between:17,35',
            'participants.*.ability' => 'required|integer|between:1,10',
            'participants.*.strength' => 'required|integer|between:1,10',
            'participants.*.speed' => 'required|integer|between:1,10',
            'participants.*.reaction_time' => 'required|integer|between:1,10',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                new ValidationErrorsResource($validator->errors()),
                422
            )
        );
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreatePromotionRequest extends FormRequest
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
            'title' => 'required',
            'promo_code' => 'required',
            'promo_start' => 'required|date',
            'area_uuids' => 'required|array',
            'image' => 'image:jpg,bmp,png,jpeg'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(["errors" => $validator->getMessageBag()], 400));
    }
}

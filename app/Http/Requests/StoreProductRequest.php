<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|max:255",
            "description" => "required|max:1000",
            "category" => "required|max:20",
            "price" => "bail|required|numeric|between:0.00,999999.99",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => __("Enter product name"),
            "name.max" => __("Product name must not exceed 255 characters"),

            "description.required" => __("Enter product description"),
            "description.max" => __("Product description must not exceed 1,000 characters"),

            "category.required" => __("Enter product category"),
            "category.max" => __("Product category must not exceed 30 characters"),

            "price.required" => __("Enter product price"),
            "price.numeric" => __("Product price must be a numeric value"),
            "price.between" => __("Product price must be £0 or more & less than £1,000,000")
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            __('success') => __('false'),
            __('message') => __('Validation errors'),
            __('data') => $validator->errors()
        ]));
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        return Auth::user()->hasRole('admin');
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'price' => 'numeric|max:2147483647|nullable|min:0',
            'capacity' => 'numeric|max:2147483647|nullable|min:0',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.max' => 'The title may not be greater than 255 characters',
            'description.max' => 'The description may not be greater than 65535 characters',
            'description.required' => 'A description is required',
            'price.numeric' => 'Price must be a number',
            'price.max' => 'The price may not be greater than 2147483647',
            'capacity.numeric' => 'Capacity must be a number',
            'capacity.max' => 'The capacity may not be greater than 2147483647',
            'capacity.min' => 'The capacity must be at least 0',
            'date.required' => 'A date is required',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg',
            'image.max' => 'The image may not be greater than 2048 kilobytes',
        ];
    }
}

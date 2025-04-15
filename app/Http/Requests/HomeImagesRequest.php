<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeImagesRequest extends FormRequest
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
            'gallery' => 'nullable|array|max:50',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'gallery.max' => 'Er mogen maximaal 50 afbeeldingen worden geüpload',
            'gallery.*.image' => 'De bestanden dienen afbeeldingen te zijn',
            'gallery.*.mimes' => 'De afbeeldingen dienen bestanden te zijn van het type: jpeg, png, jpg, gif, svg',
        ];
    }
}

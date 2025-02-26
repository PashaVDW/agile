<?php

namespace App\Http\Requests;

use App\Enums\EventCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'price' => 'numeric|max:2147483647|nullable|min:0',
            'capacity' => 'numeric|max:2147483647|nullable|min:0',
            'date' => 'required|date',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|in:'.implode(',', EventCategoryEnum::toArray()),
            'payment_link' => 'nullable|string|max:255',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

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
            'banner.image' => 'The file must be an image',
            'banner.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg',
            'banner.max' => 'The image may not be greater than 2048 kilobytes',
            'payment_link.max' => 'The payment link may not be greater than 255 characters',
            'payment_link.string' => 'The payment link must be a string',
            'payment_link.required' => 'A payment link is required',
            'category.required' => 'A category is required',
            'category.in' => 'The selected category is invalid',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\EventCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        //update when authentication is added
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'max:65535',
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
            'title.required' => 'De titel dient verplicht in te worden gevuld',
            'title.max' => 'De titel mag niet langer zijn dan 255 karakters',
            'description.required' => 'De beschrijving dient verplicht in te worden gevuld',
            'description.max' => 'De beschrijving mag niet langer zijn dan 65535 karakters',
            'price.numeric' => 'De prijs dient een nummer te zijn',
            'price.max' => 'De prijs mag niet groter zijn dan 2147483647',
            'capacity.numeric' => 'De capaciteit dient een nummer te zijn',
            'capacity.max' => 'De capaciteit mag niet groter zijn dan 2147483647',
            'capacity.min' => 'De capaciteit dient minimaal 0 te zijn',
            'date.required' => 'Een datum is verplicht',
            'banner.image' => 'Het bestand dient een afbeelding te zijn',
            'banner.mimes' => 'De afbeelding dient een bestand te zijn van het type: jpeg, png, jpg, gif, svg',
            'banner.max' => 'De afbeelding mag niet groter zijn dan 2048 kilobytes',
            'payment_link.max' => 'De betaallink mag niet langer zijn dan 255 karakters',
            'payment_link.string' => 'De betaallink dient een string te zijn',
            'category.required' => 'Een categorie is verplicht',
            'category.in' => 'De geselecteerde categorie is ongeldig',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discord_enabled' => 'boolean',
            'discord_type' => 'nullable|string|in:standard,embed',
            'discord_channel' => 'nullable|string|max:255',
            'discord_tag' => 'nullable|string|max:255',
            'discord_title' => 'nullable|string|max:255',
            'discord_description' => 'nullable|string|max:65535',
            'discord_embed_color' => 'nullable|string|max:7',
            'discord_embed_author' => 'nullable|string|max:255',
            'discord_embed_author_url' => 'nullable|string|url|max:255',
        ];
    }
}

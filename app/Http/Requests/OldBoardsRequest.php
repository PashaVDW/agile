<?php

namespace App\Http\Requests;

use App\Rules\TermRange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OldBoardsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'names' => 'required|max:1000|string',
            'term' => ['required', new TermRange],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht.',
        ];
    }
}

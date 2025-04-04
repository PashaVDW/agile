<?php

namespace App\Http\Requests;

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
            'term' => ['required', 'regex:/^(\d{4})\/(\d{4})$/', function ($attribute, $value, $fail) {
                preg_match('/^(\d{4})\/(\d{4})$/', $value, $matches);

                if (!$matches) {
                    return $fail('het termijn formaat is: YYYY/YYYY.');
                }

                $startYear = (int) $matches[1];
                $endYear = (int) $matches[2];

                if ($endYear !== $startYear + 1) {
                    return $fail('Het termijn moet op een volgende jaren zijn(e.g., 2024/2025).');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht.',
        ];
    }
}

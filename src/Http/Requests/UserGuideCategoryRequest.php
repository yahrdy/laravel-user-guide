<?php

namespace Hridoy\LaravelUserGuide\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGuideCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'video' => 'nullable|string'
        ];
        $newRules = array();

        if ($this->isMethod('POST')) {
            $newRules = [
                'name' => 'required|string',
            ];
        }
        if ($this->isMethod('PUT')) {
            $newRules = [
                'name' => 'string',
            ];
        }
        return array_merge($rules, $newRules);
    }
}

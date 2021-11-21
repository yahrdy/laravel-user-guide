<?php

namespace Hridoy\LaravelUserGuide\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'user_guide_category_id' => 'nullable|integer|exists:user_guide_categories,id',
            'description' => 'nullable|string',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'video' => 'nullable|string'
        ];
        $newRules = array();

        if ($this->isMethod('POST')) {
            $newRules = [
                'title' => 'required|string'
            ];
        }
        if ($this->isMethod('PUT')) {
            $newRules = [
                'title' => 'string'
            ];
        }
        return array_merge($rules, $newRules);
    }
}

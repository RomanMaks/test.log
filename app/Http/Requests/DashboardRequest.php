<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['nullable', 'date'],
            'os' => ['nullable', 'string'],
            'architecture' => ['nullable', 'string']
        ];
    }
}

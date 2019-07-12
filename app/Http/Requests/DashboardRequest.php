<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидация данных прищедших в запросе
 *
 * Class DashboardRequest
 * @package App\Http\Requests
 */
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

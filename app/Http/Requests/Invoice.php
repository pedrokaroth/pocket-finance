<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Invoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'description' => 'required|min:3|max:191',
            'due_at' => 'required',
            'value' => 'required',
            'wallet' => 'required',
            'category' => 'required',
            'repeat_when' => 'required',
            'invoice' => 'required|in:income,expense'
        ];
    }
}

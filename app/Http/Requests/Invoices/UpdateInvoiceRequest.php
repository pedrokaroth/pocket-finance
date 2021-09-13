<?php

namespace App\Http\Requests\Invoices;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateInvoiceRequest extends FormRequest
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
            'wallet_id' => 'required|exists:wallets,id',
            'category_id' => 'required|exists:categories,id',
            'comments' => 'max:191',
            'status' => 'in:unpaid,paid',
        ];
    }
}

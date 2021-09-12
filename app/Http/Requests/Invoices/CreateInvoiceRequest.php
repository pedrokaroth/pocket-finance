<?php

namespace App\Http\Requests\Invoices;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CreateInvoiceRequest
 * @package App\Http\Requests\Invoices
 */
class CreateInvoiceRequest extends FormRequest
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
            'repeat_when' => 'required|in:single,fixed,enrollment',
            'type' => 'required|in:income,expense',
            'comments' => 'max:191',
            'status' => 'in:unpaid,paid'
        ];
    }

    /**
     *  Set the correct value for validate function
     *
     */
    protected function prepareForValidation()
    {
        if(!$this->has('status')) {
            /*
             * Default status value
             */
            $this->merge([
                'status' => $this->get('due_at') <= Carbon::now()
                    ? 'paid'
                    : 'unpaid'
            ]);
        }
    }
}

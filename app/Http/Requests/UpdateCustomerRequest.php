<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $this->route('customer')->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive,suspended',
            'connection_date' => 'required|date',
            'service_package_id' => 'required|exists:service_packages,id',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Customer name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered to another customer.',
            'address.required' => 'Customer address is required.',
            'status.required' => 'Customer status is required.',
            'connection_date.required' => 'Connection date is required.',
            'service_package_id.required' => 'Service package is required.',
            'service_package_id.exists' => 'Selected service package is invalid.',
        ];
    }
}
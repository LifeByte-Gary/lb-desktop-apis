<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'company' => ['required', 'string'],
            'department' => ['string'],
            'job_title' => ['string'],
            'desk' => ['string'],
            'type' => ['required', Rule::in(['Employee', 'Storage', 'Meeting Room', 'Others'])],
            'state' => ['required', 'numeric', 'min:0', 'max:1'],
            'permission_level' => ['required', 'numeric', 'min:0', $this->user()->isAdminManager() ? 'max:2' : 'max:0'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property User $user
 */
class UpdateUserRequest extends FormRequest
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
            'name' => ['string'],
            'email' => ['email', Rule::unique(User::class, 'email')->ignore($this->user->id)],
            'company' => ['string'],
            'department' => ['string', 'nullable'],
            'job_title' => ['string', 'nullable'],
            'desk' => ['string', 'nullable'],
            'type' => [Rule::in(['Employee', 'Storage', 'Meeting Room', 'Others'])],
            'state' => ['numeric', 'min:0', 'max:1'],
            'permission_level' => ['numeric', 'min:0', $this->user()->isAdminManager() ? 'max:2' : 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'permission_level.max' => 'Only an IT manager can update a user to a high permission level.'
        ];
    }
}

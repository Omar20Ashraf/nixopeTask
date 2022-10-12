<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            //
            'name' => 'required|string|max:190',
            'roles_id' => 'required|array|min:1',
            'roles_id.*' => 'numeric|exists:roles,id',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'email' => ['required', 'string', 'email', 'max:190', Rule::unique(User::class)],
            ];
        } else {
            $rules += [
                'email' => ['required', 'string', 'email', 'max:190', Rule::unique(User::class)->ignore($this->user->id)],
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        // code...

        return  [
            'name' => 'Name',
            'email' => 'Email',
            'roles_id' => 'Roles',
            'roles_id.*' => 'Roles',
        ];
    }
}

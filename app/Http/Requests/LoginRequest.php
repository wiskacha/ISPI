<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
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
            'email_or_nick' => 'required|string', // Updated to a single field for email or nick
            'password' => 'required|string',
        ];
    }

    /**
     * Get the credentials for authentication.
     *
     * @return array<string, string>
     */
    public function getCredentials(): array
    {
        // Use 'email_or_nick' from the form input
        $loginField = $this->get('email_or_nick');

        // Determine if the input is an email or a nickname
        if ($this->isEmail($loginField)) {
            return [
                'email' => $loginField,
                'password' => $this->get('password'),
            ];
        }

        return [
            'nick' => $loginField,
            'password' => $this->get('password'),
        ];
    }

    /**
     * Check if the given value is a valid email address.
     *
     * @param string $value
     * @return bool
     */
    public function isEmail(string $value): bool
    {
        $factory = $this->container->make(ValidationFactory::class);

        return !$factory->make(['email' => $value], ['email' => 'email'])->fails();
    }
}

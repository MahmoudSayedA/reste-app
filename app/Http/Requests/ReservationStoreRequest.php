<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReservationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user() && Auth::user()->is_admin)
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'alpha_dash:ascii', 'max:50'],
            'last_name' => ['required', 'alpha_dash:ascii', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:50', 'regex:/^(?:\+20|0)?1\d{9}$/'],
            'table_id' => ['required',],
            'guest_num' => ['required',],
            // 'reservation_date' => ['required'],
            'reservation_date' => ['required', 'date_format:Y-m-d\TH:i', 'after:now', 'before:+8 day'],
        ];
    }
}

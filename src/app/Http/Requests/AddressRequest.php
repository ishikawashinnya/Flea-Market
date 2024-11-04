<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'postcode' => ['required', 'string', 'regex:/^(?!.*[^0-9-]).*$/', 'regex:/^\d{3}-\d{4}$|^\d{7}$/'],
            'address' => ['required', 'string', 'max:191'],
            'building' => ['nullable', 'string', 'max:191']
        ];
    }

    public function messages() 
    {
        return [
            'postcode.required' => '郵便番号を入力してください',
            'postcode.string' => '郵便番号を文字列で入力してください',
            'postcode.regex' => '郵便番号は「123-4567」または「1234567」の形式で、1-9の数字のみで入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所を文字列で入力してください',
            'address.max' => '住所を191文字以下で入力してください',
            'building.string' => '建物名を文字列で入力してください',
            'building.max' => '建物名を191文字以下で入力してください',
        ];
    }
}

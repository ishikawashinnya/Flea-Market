<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'img_url' => ['nullable', 'file', 'mimes:jpeg,png', 'max:10240'],
            'shipping_name' => ['required', 'string', 'max:191'],
            'postcode' => ['required', 'string', 'regex:/^(?!.*[^0-9-]).*$/', 'regex:/^\d{3}-\d{4}$|^\d{7}$/'],
            'address' => ['required', 'string', 'max:191'],
            'building' => ['nullable', 'string', 'max:191']
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.string' => 'ユーザー名を文字列で入力してください',
            'name.max' => 'ユーザー名を191文字以下で入力してください',
            'img_url.file' => '有効なファイルをアップロードしてください',
            'img_url.mimes' => 'ファイル形式はjpeg,pngのみ有効です',
            'img_url.max' => 'ファイルサイズは10M以下で選択してください',
            'shipping_name.required' => 'ユーザー名を入力してください',
            'shipping_name.string' => 'ユーザー名を文字列で入力してください',
            'shipping_name.max' => 'ユーザー名を191文字以下で入力してください',
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

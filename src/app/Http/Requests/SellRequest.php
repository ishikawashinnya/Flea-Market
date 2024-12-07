<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
        $item_id = $this->route('id');
        $item = $item_id ? \App\Models\Item::find($item_id) : null;

        return [
            'name' => ['required'],
            'price' => ['required', 'regex:/^[1-9][0-9]*$/'],
            'description' => ['required'],
            'img_url' => [$item && $item->img_url ? 'nullable' : 'required', 'file', 'mimes:jpeg,png',],
            'condition_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '販売価格を半角数字で入力してください',
            'price.regex' => '販売価格を半角数字で入力してください',
            'description.required' => '商品の説明を入力してください',
            'img_url.required' => '画像ファイルを選択してください',
            'img_url.file' => '有効なファイルをアップロードしてください',
            'img_url.mimes' => 'ファイル形式はjpeg,pngのみ有効です',
            'condition_id.required' => '商品の状態を選択してください',
        ];
    }
}
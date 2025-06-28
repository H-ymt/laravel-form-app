<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormEntryRequest extends FormRequest
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
            'name' => 'required|max:100',
            'kana_name' => ['required', 'max:100', 'regex:/^[ァ-ヶー]+$/u'],
            'phone_number' => ['required','digits_between:10,11','regex:/^(0[3-9]\d{8}|0[789]0\d{8})$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:form_entrys,email'],
            'birth_day' => ['required', 'date'],
            'additional_info' => ['required', 'string'],
            'agreement' => ['accepted'],
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'name.required' => '名前は必須です。',
            'name.max' => '名前は100文字以内で入力してください。',
            'kana_name.max' => 'フリガナは100文字以内で入力してください。',
            'kana_name.required' => 'フリガナは必須です。',
            'kana_name.regex' => 'フリガナは全角カタカナのみ入力してください。',
            'phone_number.required' => '電話番号は必須です。',
            'phone_number.regex' => '正しい電話番号形式で入力してください。',
            'phone_number.digits_between' => '正しい電話番号形式で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスはすでに使用されています。',
            'birth_day.required' => '生年月日は必須です。',
            'birth_day.date' => '正しい日付形式で入力してください。',
            'additional_info.required' => '追加情報は必須です。',
            'additional_info.string' => '追加情報は文字列で入力してください。',
            'agreement.accepted' => '利用規約に同意する必要があります。',
        ];
    }
}

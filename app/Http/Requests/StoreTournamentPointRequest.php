<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentPointRequest extends FormRequest
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
            'grade' => 'required|string|max:50',
            'points' => 'required|array|min:1',
            'points.*.round' => 'required|string|max:50',
            'points.*.points' => 'required|integer|min:0|max:100000',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'grade.required' => 'ポイント区分（登録名）を入力してください。',
            'grade.string' => 'ポイント区分（登録名）は文字列で入力してください。',
            'grade.max' => 'ポイント区分（登録名）は50文字以内で入力してください。',

            'points.required' => 'ポイント設定を入力してください。',
            'points.array' => 'ポイント設定のデータ形式が正しくありません。',
            'points.min' => '最低1つのポイント設定が必要です。',

            'points.*.round.required' => '成績・ラウンドを入力してください。',
            'points.*.round.string' => '成績・ラウンドは文字列で入力してください。',
            'points.*.round.max' => '成績・ラウンドは50文字以内で入力してください。',

            'points.*.points.required' => 'ポイントを入力してください。',
            'points.*.points.integer' => 'ポイントは整数で入力してください。',
            'points.*.points.min' => 'ポイントは0以上で入力してください。',
            'points.*.points.max' => 'ポイントは100000以下で入力してください。',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'grade' => 'ポイント区分',
            'points.*.round' => '成績・ラウンド',
            'points.*.points' => 'ポイント',
        ];
    }
}

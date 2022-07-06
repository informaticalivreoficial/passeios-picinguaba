<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Passeio extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roteiro_id' => 'required',
            'valor_venda' => 'required_if:venda,on',
            'valor_locacao' => 'required_if:locacao,on',
        ];
    }

    public function messages()
    {
        return [
            'required_if' => 'O campo :attribute é obrigatório quando :other for selecionado.',
        ];
    }
}

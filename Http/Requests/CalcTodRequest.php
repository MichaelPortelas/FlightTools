<?php

namespace Modules\FlightTools\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalcTodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Vous pouvez ajuster cette logique si nécessaire
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'actfl' => 'required|numeric|min:10|max:500',
            'fixfl'  => 'required|numeric|min:10|max:500',
            'gspeed' => 'required|numeric|min:0|max:999',
        ];
    }
}

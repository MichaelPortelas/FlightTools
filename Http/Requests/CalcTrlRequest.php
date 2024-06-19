<?php

namespace Modules\FlightTools\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalcTrlRequest extends FormRequest
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
            'qnh' => 'required|numeric|min:900|max:1100',
            'ta'  => 'required|numeric|min:0|max:50000',
        ];
    }
}

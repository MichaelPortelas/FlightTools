<?php

namespace Modules\FlightTools\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalcAeroRequest extends FormRequest
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
            'indicatedAirspeed' => 'required|integer|min:0|max:999',
            'altitude'  => 'required|integer|min:0|max:50000',
            'magneticHeading' => 'required|integer|min:0|max:360',
            'distance' => 'required|integer|min:0|max:8000',
            'windOrigin' => 'required|integer|min:0|max:360',
            'windSpeed' => 'required|integer|min:0|max:200',
            'temperature' => 'required|integer|min:0|max:60',
        ];
    }
}
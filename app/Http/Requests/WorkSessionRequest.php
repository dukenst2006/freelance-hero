<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class WorkSessionRequest extends Request
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
            'project_id' => 'required'
        ];
    }

    /**
     * Get the custom validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'project_id.required' => 'Please select a project.'
        ];
    }
}

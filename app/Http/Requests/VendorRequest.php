<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class VendorRequest.
 */
class VendorRequest extends Request
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

    public function attributes()
    {
        return [
            'mobile_number' => 'Mobile Number',
        ];
    }

    public function rules()
    {
        return [
            'mobile_number' => 'required|unique:vendors|min:10|max:10'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}

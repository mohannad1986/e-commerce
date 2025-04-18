<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

         //
            // في حال كنت لوغ ان لازم الايميل ريكواير في
            // في حال كنت ضيف لازم يكون الايميل يونيك لان الضيف مالازم يكون ايميلو موجود بقاعدة البيانات 
            $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users';
        return [

           

            
                'email' => $emailValidation,
                // 'email' => 'required|email',

                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
                'postalcode' => 'required',
                'phone' => 'required',
           

        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'You already have an account with this email address. Please <a href="/login">login</a> to continue.',
        ];
    }
}

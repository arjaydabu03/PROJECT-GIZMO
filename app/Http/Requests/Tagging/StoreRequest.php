<?php

namespace App\Http\Requests\Tagging;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            "company_code" => $this->route()->ap_tagging
            ? "unique:ap_tagging,company_code," . $this->route()->ap_tagging
            : "unique:ap_tagging,company_code",
        ];
    }
}

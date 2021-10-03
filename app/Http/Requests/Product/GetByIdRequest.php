<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class GetByIdRequest extends Request
{
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }
}

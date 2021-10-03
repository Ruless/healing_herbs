<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class SearchRequest extends Request
{
    public function rules()
    {
        return [
            'search' => 'required'
        ];
    }
}

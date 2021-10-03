<?php


namespace App\Http\Requests;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class FormRequest extends LaravelFormRequest
{
    abstract public function rules();

    abstract public function authorize();
    private $status_response = 200;
    /**
     * Get message on validation error
     *
     */
    protected function getFailedValidationMessage() {
        return "Во время выполнения запроса возникли ошибки";
    }

    protected function failedValidation(Validator $validator) {
        // $errors = (new ValidationException($validator))->errors();JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json([
                'errors' => $errors,
                'status' => false,
            ], $this->status_response)
        );
    }
}
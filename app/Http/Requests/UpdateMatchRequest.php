<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Update Match request",
 *      description="Update Match request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateMatchRequest extends FormRequest
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
            'id'     => 'required|integer',
            'result' => ['required', 'integer', Rule::in([1, 2, 3])],
        ];
    }
}

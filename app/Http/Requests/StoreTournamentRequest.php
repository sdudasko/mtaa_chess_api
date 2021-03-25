<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Tournament request",
 *      description="Store Tournament request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreTournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'           => 'required|string',
            'date'            => 'nullable|date',
            'tempo'           => 'required|integer',
            'tempo_increment' => 'nullable|integer',
            'rounds'          => 'required|integer',
            'description'     => 'nullable|string',
        ];
    }
}

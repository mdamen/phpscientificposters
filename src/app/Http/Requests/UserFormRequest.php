<?php
namespace App\Http\Requests;

/**
 * Class PosterFormRequest
 *
 * @codeCoverageIgnore
 * @package App\Http\Requests
 */
class UserFormRequest extends Request
{
    /**
    * @return bool
    */
    public function authorize()
    {
        // Only allow logged in users
        return true;
    }

    /**
    * @return array
    */
    public function rules()
    {
        return [
            'name'     => 'required|min:1',
            'username' => 'required|min:3',
            'password' => 'min:8',
        ];
    }
}
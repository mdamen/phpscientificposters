<?php
namespace App\Http\Requests;

/**
 * Class PosterFormRequest
 *
 * @codeCoverageIgnore
 * @package App\Http\Requests
 */
class UserAddFormRequest extends UserFormRequest
{
    /**
    * @return array
    */
    public function rules()
    {
        return [
            'name'     => 'required|min:1',
            'username' => 'required|min:3',
            'password' => 'required|min:8',
        ];
    }
}
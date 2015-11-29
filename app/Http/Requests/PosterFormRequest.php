<?php
namespace App\Http\Requests;

/**
 * Class AccountFormRequest
 *
 * @codeCoverageIgnore
 * @package App\Http\Requests
 */
class PosterFormRequest extends Request
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
            'title'         => 'required|min:1',
            'conference'    => 'required|min:1',
            'conference_at' => 'date',
            'contact_email' => 'email',
            'abstract'      => 'required|min:1',
        ];
    }
}
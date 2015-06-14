<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UploadTrackRequest extends Request
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
        $rules = [
            'trackeable_id'   => 'required|integer',
            'trackeable_type' => 'required',
            'tracks'          => 'required|array|min:1|max:8'
        ];

        $tracks = $this->file('tracks');

        foreach ($tracks as $key => $file) // add individual rules to each image
        {
//            $rules['tracks.'.$key] = 'required|mimes:audio/mp3,mp3,audio/mpeg,application/octet-stream';
            $rules['tracks.' . $key] = 'required|unique:tracks,name_ar';
        }

        return $rules;
    }
}

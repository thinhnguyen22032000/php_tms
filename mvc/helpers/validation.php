<?php

use Rakit\Validation\Validator;

class Validation
{
    static function validator($vals=[], $rules=[])
    {
        $errors = array();
        $validator = new Validator;
        $validation = $validator->make($vals, $rules);

        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors()->firstOfAll();

        }
        return $errors;
    }
}

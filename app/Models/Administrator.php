<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Administrator extends Model
{
    const PASSWORD_REGEX = '^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$';

    public static function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|min:2|max:255',
            'lastname' => 'required|min:2|max:255',
            'nickname' => 'required|min:2|max:255|unique:administrators',
            'email' => 'required|unique:administrators',
            'password' => 'required|confirmed|regex:/'.self::PASSWORD_REGEX.'/i',
            'lang' => 'required',
            'isActivated' => 'nullable',
        ]);
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucfirst($value);
    }

    public function getFirstnameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucfirst($value);
    }

    public function getLastnameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNicknameAttribute($value)
    {
        $this->attributes['nickname'] = mb_strtolower($value);
    }

    public function getNicknameAttribute($value)
    {
        return mb_strtolower($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        return mb_strtolower($value);
    }

    public function storeValues(array $values)
    {
        $this->firstname = $values['firstname'];
        $this->lastname = $values['lastname'];
        $this->nickname = $values['nickname'];
        $this->email = $values['email'];
        $this->password = $values['password'];
        $this->lang = $values['lang'];
        $this->isActivated = $values['isActivated'];

        $this->save();
    }
}

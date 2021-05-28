<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badges extends Model
{
    //
    public function getImgAttribute($value)
    {
        return asset($value);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class PullDetails extends Model
{
    //
    protected $table='pull_detail';

    public function getPictureAttribute($value)
    {
        if(!empty($value))
            return URL::to($value);
        else
            return URL::to("default.png");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;

class PullDetails extends Model
{
    use HasFactory;
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

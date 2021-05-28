<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class ToothReward extends Model
{
    protected $fillable = ['type','teeth_number','reward'];
}

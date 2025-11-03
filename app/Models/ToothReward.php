<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
class ToothReward extends Model
{
    use HasFactory;
    protected $fillable = ['type','teeth_number','reward'];
}

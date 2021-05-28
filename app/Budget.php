<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Budget extends Model
{
    protected $fillable = ['amount','user_id'];
    public function User()
    {
        return $this->hasOne(User::class, 'id');
    }
}

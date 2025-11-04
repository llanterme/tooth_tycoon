<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
class Budget extends Model
{
    use HasFactory;
    protected $fillable = ['amount','user_id'];
    public function User()
    {
        return $this->hasOne(User::class, 'id');
    }
}

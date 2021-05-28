<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Childe;
use App\PullDetails;

class CashOut extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Childe()
    {
        return $this->belongsTo(Childe::class,'child_id');
    }

    public function PullDetail()
    {
        return $this->belongsTo(PullDetails::class,'pull_detail_id');
    }
}

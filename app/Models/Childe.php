<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\PullDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class Childe extends Model
{
    use HasFactory;
    protected $appends = ['TeethCount','age'];

    protected $table="childe";

    public function getImgAttribute($value)
    {
        return URL::to($value);
    }


    public function getTeethCountAttribute()
    {
        return $this->attributes['TeethCount']=PullDetails::where('child_id',$this->attributes['id'])->count();
    }

    public function PullDetails()
    {
        return $this->hasMany(PullDetails::class, 'child_id');
    }



    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['age'])->age;
    }
}

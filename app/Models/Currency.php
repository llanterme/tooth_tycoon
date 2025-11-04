<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\PullDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    use HasFactory;
    //protected $appends = ['TeethCount','age'];

    protected $table="currency";

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PullDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    //protected $appends = ['TeethCount','age'];

    protected $table="currency";

}

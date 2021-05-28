<?php

namespace App\Http\Repository;

use Illuminate\Http\Request;

class BaseController
{
    public function ResponseJson($status,$msg,$data,$responce_code="201")
    {
        return response(['status'=>$status,'message'=>$msg,'data'=>$data],$responce_code);
    }
}

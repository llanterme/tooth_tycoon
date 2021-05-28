<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repository\CustomEncryption;
class TestController extends Controller
{
    public function exception(Request $request,CustomEncryption $customEncryption)
    {
        $sting=$customEncryption->encryption($request->string);
        return response(['encode'=>$sting,'post_request'=>$request->all()],200);
    }
    public function decryption(Request $request,CustomEncryption $customEncryption)
    {
        $sting=$customEncryption->decryption($request->string);
        return response(['decode'=>$sting,'post_request'=>$request->all()],200);
    }
}

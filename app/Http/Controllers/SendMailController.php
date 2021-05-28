<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\SendMail as Mail;

class SendMailController extends Controller
{
    public function __construct(Mail $SendMail)
    {
        $this->SendMail=$SendMail;
    }

    public function send()
    {
        return $this->SendMail->Send();
    }
}

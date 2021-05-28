<?php

namespace App\Http\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;

class SendMail
{
    public function WelcomeMailSend($to,$name)
    {
        Log::info('Send Welcome mail.', ['to' => $to,'name'=>$name]);
        $to_name=$name;
        $to_email=$to;
        $data=array('name'=>$to_name);
        Mail::send('email.welcome', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email)->subject('Welcome To Tooth Tycoon');
        $message->from('admin@toothtycoon.mobi','Tooth Tycoon');
        });
    }
}

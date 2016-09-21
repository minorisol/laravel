<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SendMail extends Model
{
    public static function sendTo($subject, $template, $data)
    {
        Mail::send(['text' => $template], $data,
            function($message) use ($subject, $data)
            {
                $message->to($data['email'], $data['name'])->subject($subject);
            }
        );
    }
}

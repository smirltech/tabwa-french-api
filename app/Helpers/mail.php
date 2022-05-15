<?php

use App\Mail\NotifierMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

function sendMail(Request $request)
{
    $details = [
        'subject' => $request->subject,
        'title' => $request->title,
        'body' => $request->body,
    ];
    Mail::to($request->receiver)
        ->queue(new NotifierMail($details));

    return ("Email sent to " . $request->receiver);
}

function sendNormalMail(string $receiver, $details)
{

    Mail::to($receiver)
        ->queue(new NotifierMail($details));

    return ("Normal email sent to " . $receiver);
}

function sendForgotPassMail(string $receiver, $details)
{
    Mail::to($receiver)
        ->queue(new NotifierMail($details));

    return ("Email sent to " . $receiver);
}
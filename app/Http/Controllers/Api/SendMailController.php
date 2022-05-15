<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class SendMailController extends ApiController
{
  

    public function create(Request $request)
    {
         dd(sendMail($request));

    }
}

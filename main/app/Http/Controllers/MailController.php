<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{

    public function send(Request $request){
    

        $customer_mail = [
            'email'=>$request->email,
            'name'=>$request->name
        ];

        Mail::send('mails.test', compact('customer_mail'), function($mail) use($customer_mail){
            $mail->to($customer_mail['email'])
                 ->subject('Cảm ơn bạn đã đăng ký dịch vụ');
        });

        return view('mails.notification');
    }
 
    public function testMail()
    {
        $name = 'Bảo Hoàng';
        Mail::send('mails.test', compact('name'), function($mail) use($name){
            $mail->subject('Thử mail trong laravel');
            $mail->to('hoang22201@gmail.com', $name);
        });

        return view('mails.notification');
    }
}

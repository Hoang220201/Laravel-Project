<?php

namespace Packages\Exchange\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use Packages\Exchange\Models\Contact;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        try{
            DB::beginTransaction();
            DB::table('contact')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);
            DB::commit();

            $customer_mail = [
                'email'=>$request->email,
                'name'=>$request->name
            ];

            $team_mail = [
                'email'=>$request->email,
                'name'=>$request->name,
                'message' => $request->message
            ];

            Mail::send('mails.team', compact('team_mail'), function($mail) use($team_mail){
                $mail->to('hoang22201@gmail.com')
                     ->subject('A email form '.$team_mail['email']);
            });

    
            Mail::send('mails.cxcMessage', compact('customer_mail'), function($mail) use($customer_mail){
                $mail->to($customer_mail['email'])
                     ->subject('Thank you for using CxC service');
            });
        
           
            return response()->json(['success' => true]); 
    
        } catch (Exception $e){
            DB::rollback();
            return response()->json($e); 
        }
    
    }
}
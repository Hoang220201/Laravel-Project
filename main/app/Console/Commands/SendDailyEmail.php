<?php

namespace App\Console\Commands;

;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;


class SendDailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-daily-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $date = Carbon::now();
        
        DB::table('tokens')
        ->orderBy('id')
        ->chunk(1000, function ($tokenList) use ($date) {
            foreach ($tokenList as $token) {
                $rates = DB::table('rates')
                    ->select('rates.rate_code', 'rates.rate') // Specify the table alias for rate_code
                    ->join('daily_email', 'rates.rate_code', '=', 'daily_email.rate_code')
                    ->where('daily_email.token_id', $token->id)
                    ->where('rates.base', $token->base)
                    ->get();


            $customer_mail = [
                'token' => $token->token,
                'email' => $token->email,
                'rates' => $rates,
                'base' => $token->base,
                'date' => $date->format('M(d)/Y'),
            ];
    
            Queue::push(function ($job) use ($customer_mail) {
                Mail::send('mails.cxcMail', compact('customer_mail'), function($mail) use($customer_mail){
                    $mail->to($customer_mail['email'])
                         ->subject('Thank you for using CxC service');
                });
                $job->delete();
            });
        }
    });

    }
}

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
   
    /*$req_url = 'https://api.exchangerate.host/latest?base=USD&places=6';
    $req_url = 'https://api.exchangerate.host/timeseries?start_date=2023-04-20&end_date=2023-05-20&base=VND&symbols=USD';
    //$req_url = 'https://api.exchangerate.host/fluctuation?start_date=2020-01-01&end_date=2020-01-04';
    //$req_url = 'https://api.exchangerate.host/2020-04-04'; 
    $response_json = file_get_contents($req_url);
    if(false !== $response_json) {
        try {
            $response = json_decode($response_json);
            if($response->success === true) {
                dd($response);
            }
        } catch(Exception $e) {
            // Handle JSON parse error...
        }
    }    */
   

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
            Mail::send('mails.cxcMail', compact('customer_mail'), function($mail) use($customer_mail){
                $mail->to($customer_mail['email'])
                     ->subject('Thank you for using CxC service');
            });
        }
    });

});

Route::get('/', function () {
    return view('welcome');

});

Route::get('/welcome', function () {
   
   return view('welcome');
       
});

/// route for EUD profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/// route verified before load
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('user', UserController::class)->only(['destroy', 'edit', 'update'])->middleware(['auth', 'role:admin']);

Route::post('/user/restore/{user}', [UserController::class, 'restore'])
    ->middleware(['auth'])
    ->withTrashed()
    ->name('restore');


Route::get('/test/{slug}', function () {
       return view('test');
})->middleware('url:{slug}');

/*Route::get('/contact',  function () {
    return view('mails.contactForm');
})->name('contact');*/

Route::get('/test-mail', [MailController::class, 'testMail']);

Route::post('/send', [MailController::class, 'send'])->name('send.email');



require __DIR__.'/auth.php';

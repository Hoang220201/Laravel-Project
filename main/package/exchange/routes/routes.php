<?php
    
    $namespace = 'Packages\Exchange\Http\Controllers';
    use Packages\Exchange\Http\Controllers\HomeController;
    use Packages\Exchange\Http\Controllers\HistoryRatesController;
    use Packages\Exchange\Http\Controllers\ContactController;
    use Packages\Exchange\Http\Controllers\LineChartController;
    use Illuminate\Support\Facades\Route;
    
    Route::namespace($namespace)->group(function() {
        //home page
        Route::get('/home', [HomeController::class,'index']);
        Route::get('main/public/change-base', [HomeController::class,'changeBase'])->name('change.base');
        Route::get('main/public/convert', [HomeController::class,'convert'])->name('convert.currency');
        Route::post('main/public/mailsend', [HomeController::class,'sendMail']);

        //history rate + bar chart page
        Route::get('/history', [HistoryRatesController::class,'history'])->name('history.default');

        //contact page
        Route::get('/contact',  function () {
            return view('Exchange::content.contact');
        });
        Route::post('main/public/contactsubmit',[ContactController::class,'index']);

        //unSubscribe router
        Route::get('/unsubscribe', [HomeController::class,'unSubscribe']);

    });

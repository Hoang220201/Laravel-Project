<?php

namespace Packages\Exchange\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;

class HistoryRatesController extends Controller
{
    public function history()
    {
        try{
            $base = 'USD';
            $date = Carbon::now();


            $req_url = 'https://api.exchangerate.host/'.$date->toDateString().'?base='.$base;
            $response_json = file_get_contents($req_url);
            if(false !== $response_json) {
            
                    
                    $response = json_decode($response_json);

                    if($response->success === true) {
                        return view('Exchange::content.history', ['history' => $response,'base' => $base,]);
                    }
                
            } 
        } catch (Exception $e){
            return response()->json($e); 
        }
    
    }
}
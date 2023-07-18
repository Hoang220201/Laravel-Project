<?php
namespace Packages\Exchange\Services;

use Packages\Exchange\Models\Symbol;
use Packages\Exchange\Models\Rate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;

class ExchangeService
{
    public function index()
    {          
        try
        {
            Session::put('base', 'USD');
            $base = Session::get('base');
            $target = ("VND");

            //if để tránh việc call lại api khi refresh trang
            if(Rate::count() === 0){
                $this->callApiSymbols();
                $this->callApiRates($base);
            }
            $data = Rate::join('symbols', 'rates.rate_code','symbols.code')
            ->where('rates.base',$base)
            ->get(['symbols.code','rates.rate' ,'symbols.description']);


            return view('Exchange::content.index', ['data' => $data,'base' => $base,'target' => $target]);
        }
        catch(Exception $e)
        {
            return response()->json($e); 
        }

    }

    
    public function callApiSymbols(){
        // Gọi API lấy symbols của tường loại tiền và lưu vào db
        $req_url = 'https://api.exchangerate.host/symbols';
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if($response->success === true) {
                    $symbols=$response->symbols;
                    foreach($symbols as $key=>$value)
                    {
                        Symbol::create(
                            [
                               'description' => $value->description,
                               'code' => $value->code
                            ]
                        );
                    };
              
                }
        
            } 
            catch(Exception $e) 
            {
                return response()->json($e);           
            }
        }  
    }

    public function callApiRates($base){
        // Gọi API lấy rate và lưu vào db
        $req_url = 'https://api.exchangerate.host/latest?base='.$base.'&places=6'; 
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try { 
               
                $response = json_decode($response_json);
                if($response->success === true) {
                    
                    $rate=$response;
                    foreach($rate->rates as $key=>$value)
                    {
                        Rate::create(
                            [
                                'base'=>$base,
                                'rate_code' => $key,
                                'rate' => $value
                            ]
                        );
                    };
                }
            } 
            catch(Exception $e) {
                return response()->json($e); 
            }
        }
    }

    public function changeBase($request)
    {
        try
        {
            $base = $request->base;
            //if để tránh việc gọi api lấy rate đã tồn tại trong db
            if(!(Rate::where('base', $base)->exists())){
                $this->callApiRates($base);
            }

            $data = Rate::join('symbols', 'rates.rate_code','symbols.code')
            ->where('rates.base',$base)
            ->get(['symbols.code','rates.rate' ,'symbols.description']);

           
            return response()->json($data);
           
        }
        catch(Exception $e)
        {

            return response()->json($e); 
        }
    }


    public function convert($req){
        try
        {
        
            $obj = $req->all();
    
            if(!(Rate::where('base',$obj['obj']['convertFrom'])->exists())){
                $this->callApiRates($obj['obj']['convertFrom']);
            }

            $Rates=[];
            $i=0;
            foreach($obj['obj']['convertTo'] as $item )
            {   
                $rate = Rate::where('rate_code',$item)
                            ->where('base',$obj['obj']['convertFrom'])
                            ->first();
                $Rates[$i]= $rate;  
                $i++;
            }
    
            $finalResult = [];
            for($i=0;$i< count($Rates);$i++)
            {
                $tempResult = $obj['obj']['amount'] * $Rates[$i]->rate;
                $formattedResult = number_format($tempResult, 0, '.', ',');
                $finalResult[$i] =[
                    'amount'=>$obj['obj']['amount'] ,
                    'from'=>$obj['obj']['convertFrom'],
                    'to'=>$Rates[$i]->rate_code ,
                    'result'=>$formattedResult
                ];
            }

                   
            /*
             $Rate = Rate::where('rate_code',$obj['obj']['convertTo'])
                    ->where('base',$obj['obj']['convertFrom'])
                    ->first();

            $Result = $obj['obj']['amount'] * $Rate->rate;
            $finalResult = [
                'amount'=>$obj['obj']['amount'] ,
                'from'=>$obj['obj']['convertFrom'],
                'to'=>$obj['obj']['convertTo'] ,
                'result'=>$Result
            ];*/
             
           // return $finalResult ;
            return response()->json($finalResult); 
        }
        catch(Exception $e)
        {
            return response()->json($e); 
        }
        
    }

    public function sendMail($request){
        try{
           
            $currencies = $request->currencies;
        
        
            $token = Str::random(30);
            DB::table('tokens')->insert([
                'token' => $token,
                'email' => $request->email,
                'base' => $request->base,
            ]);
            
            $tokenId = DB::table('tokens')
                ->where('token', $token)
                ->value('id');




            foreach ($currencies as $item) {
                DB::table('daily_email')->insert([
                    'token_id' => $tokenId,
                    'rate_code' => $item,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        
                    
            return response()->json(['success' => true]); 
    

        } catch(Exception $e){
            return response()->json($e); 
        }
    }

    public function unSubscribe($request){
        try{
            $token = $request->query('token');
             DB::table('tokens')
                ->where('token', $token)
                ->delete();
                
        
        
            return view('Exchange::content.unsubscribe');
    

        } catch(Exception $e){
           abort(404);
        }
    }
}

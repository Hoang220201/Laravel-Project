<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UpdateRates extends Command
{
    protected $signature = 'rates:update';

    protected $description = 'Update rates from API';

    public function handle()
    {
        $req_url = 'https://api.exchangerate.host/latest?base=USD';

        $response = Http::get($req_url);

        if ($response->ok()) {
            $rates = $response->json()['rates'];

            // Update the 'rates' table with the retrieved rates
            DB::beginTransaction();
            foreach ($rates as $rateCode => $rate) {
                DB::table('rates')->updateOrInsert(
                    ['base' => 'USD', 'rate_code' => $rateCode],
                    ['rate' => $rate]
                   
                );
            }
            DB::commit();

            $this->info('Rates updated successfully.');
        } else {
            DB::rollback();
            $this->error('Failed to update rates.');
        }
    }
}

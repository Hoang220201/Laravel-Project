<?php
namespace Packages\Exchange\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Exchange\Services\ExchangeService;

class HomeController extends Controller
{
    protected $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    public function index()
    {
        return $this->exchangeService->index();
    }

    public function callApiSymbols()
    {
        return $this->exchangeService->callApiSymbols();
    }

    public function callApiRates($base)
    {
        return $this->exchangeService->callApiRates($base);
    }

    public function changeBase(Request $request)
    {
        return $this->exchangeService->changeBase($request);
    }

    public function convert(Request $req)
    {
        return $this->exchangeService->convert($req);
    }

    public function sendMail(Request $request)
    {
        return $this->exchangeService->sendMail($request);
    }

    public function unSubscribe(Request $request)
    {
        return $this->exchangeService->unSubscribe($request);
    }
}

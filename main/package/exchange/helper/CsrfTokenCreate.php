<?php 

namespace Packages\Exchange\Helper;

use Illuminate\Support\Facades\Session;

class CsrfTokenCreate
{
    public static function getCsrfToken()
    {
        return Session::token();
    }
}
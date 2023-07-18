<?php

namespace Packages\Exchange\Models;

use Illuminate\Database\Eloquent\Model;

class DailyEmail extends Model
{
    //
    protected $fillable =['id','email', 'base', 'rate_code'];
    protected $table='daily_email';

}

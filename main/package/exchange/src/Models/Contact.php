<?php

namespace Packages\Exchange\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable =['id','name','email', 'message'];
    protected $table='contact';

}

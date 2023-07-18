<?php

namespace Packages\Exchange\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Symbol extends Model
{
    //
    protected $fillable =['id','description','code'];
    protected $table='symbols';

}

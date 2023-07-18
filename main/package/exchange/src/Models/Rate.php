<?php

namespace Packages\Exchange\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rate extends Model
{
    //
    protected $fillable =['base','rate_code','rate'];
    protected $table ='rates';
    //protected $casts = ['rate' => 'decimal:18,8'];

}

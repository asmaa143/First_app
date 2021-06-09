<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'user_id',

    ];

//    protected $user=['phone'=>'array'];



    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}

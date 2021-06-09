<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;



class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name='admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',

    ];

    public function setPasswordAttribute($password){
        if(!empty($password)){
            $this->attributes['password']=bcrypt($password);
        }
    }


    public function news() {
        return $this->hasMany('App\Models\News','admin_id','id');
    }

}

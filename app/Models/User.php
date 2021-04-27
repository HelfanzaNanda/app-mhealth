<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $guarded = [];
    public $timestamps = false;

    public function bidanProfile(){
    	return $this->hasOne('App\Models\BidanProfile','bidanid','userid');
    }
    public function pasienProfile(){
    	return $this->hasOne('App\Models\PasienProfile','pasienid','userid');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidanProfile extends Model
{
    protected $table = 'bidan_profile';
    public $timestamps = false;
    public function user(){
    	return $this->hasOne('App\Models\User','userid','bidanid');
    }
}

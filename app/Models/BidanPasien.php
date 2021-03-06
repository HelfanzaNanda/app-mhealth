<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidanPasien extends Model
{
    protected $table = 'bidan_pasien';
    public $timestamps = false;
    public function bidan(){
    	return $this->hasOne('App\Models\BidanPasien','bidanid','bidanid');
    }
    public function pasien(){
    	return $this->hasOne('App\Models\PasienProfile','pasienid','pasienid');
    }
}

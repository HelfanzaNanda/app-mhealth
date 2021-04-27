<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    public $timestamps = false;
    public function pasien(){
    	return $this->hasOne('App\Models\PasienProfile','pasienid');
    }
    public function bidan(){
    	return $this->hasOne('App\Models\BidanProfile','bidanid');
    }
}

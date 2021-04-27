<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLab extends Model
{
    protected $table = 'pemeriksaan_lab';
    public $timestamps = false;
    public function pasien(){
    	return $this->hasOne('App\Models\PasienProfile','pasienid');
    }
    public function bidan(){
    	return $this->hasOne('App\Models\BidanProfile','bidanid');
    }
}

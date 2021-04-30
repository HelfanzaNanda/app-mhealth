<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function kelurahan(){
        return $this->hasOne('App\Models\Kelurahan','kelurahanId','kelurahanid');
    }
    public function kecamatan(){
        return $this->hasOne('App\Models\Kecamatan','kecamatanId','kecamatanid');
    }
    public function kabupaten(){
        return $this->hasOne('App\Models\Kabupaten','kabupatenId','kabupatenid');
    } 
    public function provinsi(){
        return $this->hasOne('App\Models\Provinsi','provinsiId','provinsiid');
    }
    public function scopeWithAddress($query){
        return $query->with('kelurahan','kecamatan','kabupaten','provinsi');
    }

    public function getAgeAttribute() {
        return Carbon::parse($this->attributes['tanggallahir'])->age;
    }
}

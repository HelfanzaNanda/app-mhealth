<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanFisik extends Model
{
    protected $table = 'pemeriksaan_fisik';
    protected $guarded = [];
    public $timestamps = false;
    public function pasien()
    {
        return $this->hasOne('App\Models\PasienProfile', 'pasienid');
    }
    public function bidan()
    {
        return $this->hasOne('App\Models\BidanProfile', 'bidanid');
    }
}

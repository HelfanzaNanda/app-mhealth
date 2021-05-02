<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faskes extends Model
{
    protected $table = 'faskes';
    public $timestamps = false;
    protected $guarded = [];
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahanid', 'kelurahanId');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatanid', 'kecamatanId');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupatenid', 'kabupatenId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromosiKesehatan extends Model
{
    protected $table = 'promosi_kesehatan';
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = [
        'date'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
   
}

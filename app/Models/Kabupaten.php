<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'master_kabupaten';
    public $timestamps = false;

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsiId', 'provinsiId');
    }
}

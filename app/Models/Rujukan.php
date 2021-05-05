<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
    protected $table = 'rujukan';
    public $timestamps = false;
    protected $guarded = [];

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidanid', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasienid', 'id');
    }

    public function faskes()
    {
        return $this->belongsTo(Faskes::class, 'faskesid', 'id');
    }
}

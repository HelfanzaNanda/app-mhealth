<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PasienRiwayatKontrasepsi;
use Illuminate\Http\Request;

class PasienRiwayatKontrasepsiController extends Controller
{
    public function save()
    {
        $userid = $this->jwt_data['uid'];
        PasienRiwayatKontrasepsi::insert([
            'pasienid' => $userid,
            'current_pregnancy' => request()->input('current_pregnancy'),
            'before_current_pregnancy' => request()->input('before_current_pregnancy'),
        ]);
        return response()->json(['status' => 1]);
    }
}

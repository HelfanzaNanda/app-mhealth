<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BidanTindakanController extends Controller
{
    public function save()
    {
        dd(request()->all());
        // Kunjungan::create([
        //     'bidanid' => $userID,
        //     'pasienid' => request()->input('pasienId'),
        //     'date' => $date,
        // ]);
        return response()->json(['status' => 1]);
    }
}

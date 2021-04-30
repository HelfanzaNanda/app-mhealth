<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidanKunjunganController extends Controller
{
    public function save()
    {
        $userID = $this->jwt_data['uid'];
        $date = Carbon::createFromFormat('m/d/Y', request()->input('date'))->format('Y-m-d');
        Kunjungan::create([
            'bidanid' => $userID,
            'pasienid' => request()->input('pasienId'),
            'date' => $date,
        ]);
        return response()->json(['status' => 1]);
    }
}

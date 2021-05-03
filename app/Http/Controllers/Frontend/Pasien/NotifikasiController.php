<?php

namespace App\Http\Controllers\Frontend\Pasien;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends HomeController
{
    public function index()
    {
        $userID = $this->jwt_data['uid'];
        $notifications = Notifikasi::where('userid', $userID)->get();
        return view('frontend.pasien.notifikasi.index', [
            'notifications' => $notifications
        ]);
    }
}

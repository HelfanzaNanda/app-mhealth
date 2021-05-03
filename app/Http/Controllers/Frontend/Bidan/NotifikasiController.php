<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;

class NotifikasiController extends HomeController
{
    public function index()
    {
        $userID = $this->jwt_data['uid'];
        $notifications = Notifikasi::where('userid', $userID)->get();
        return view('frontend.bidan.notifikasi.index', [
            'notifications' => $notifications
        ]);
    }
}
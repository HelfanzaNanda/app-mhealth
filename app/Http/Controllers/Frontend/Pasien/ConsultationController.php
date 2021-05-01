<?php

namespace App\Http\Controllers\Frontend\Pasien;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\Inbox;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class ConsultationController extends HomeController
{
    public function index()
	{
        $userID = $this->jwt_data['uid'];
        $kunjungan = Kunjungan::where('pasienid', $userID)->orderBy('date', 'DESC')->first();
        if ($kunjungan) {
            $status = true;
            $messages = Inbox::where('pasienid', $userID)->where('bidanid', $kunjungan->bidanid)->get();
            $message = Inbox::where('pasienid', $userID)->where('bidanid', $kunjungan->bidanid)
            ->where('pengirim', '!=', $userID)
            ->orderBy('id', 'desc')->first();
            $message->update([
                'status' => 'read'
            ]);
        }else{
            $status = false;
            $messages = 'all';
        }
		return view('frontend.pasien.modal.consultation.index', [
            'kunjungan' => $kunjungan,
            'messages' => $messages,
            'status' => $status,
            'user_id' => $userID
        ]);
	}

    public function sendMessage(Request $request)
    {
        Inbox::create([
            'pasienid' => $this->jwt_data['uid'],
            'pengirim' => $this->jwt_data['uid'],
            'bidanid' => $request->bidanid,
            'message' => $request->message
        ]);
        return response()->json(['status'=>1]);
    }
}

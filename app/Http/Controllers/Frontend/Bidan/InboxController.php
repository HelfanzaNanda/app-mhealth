<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Models\Inbox;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;

class InboxController extends HomeController
{
    public function index()
    {
        $userID = $this->jwt_data['uid'];
        $kunjungans = Kunjungan::where('bidanid', $userID)->get();
        return view('frontend.bidan.inbox.index', [
            'kunjungans' => $kunjungans
        ]);
    }

    public function showChat($id)
	{
        $userID = $this->jwt_data['uid'];
        $kunjungan = Kunjungan::where('id', $id)->first();
        
        $messages = Inbox::where('bidanid', $userID)->where('pasienid', $kunjungan->pasienid)->get();
        $message = Inbox::where('bidanid', $userID)->where('pasienid', $kunjungan->pasienid)
        ->where('pengirim', '!=', $userID)
        ->orderBy('id', 'desc')->first();
        $message->update([
            'status' => 'read'
        ]);
		return view('frontend.bidan.modal.chat.index', [
            'kunjungan' => $kunjungan,
            'messages' => $messages,
            'user_id' => $userID
        ]);
	}

    public function sendMessage(Request $request)
    {
        Inbox::create([
            'bidanid' => $this->jwt_data['uid'],
            'pengirim' => $this->jwt_data['uid'],
            'pasienid' => $request->pasienid,
            'message' => $request->message
        ]);
        return response()->json(['status'=>1]);
    }
}

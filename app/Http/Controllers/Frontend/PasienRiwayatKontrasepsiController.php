<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PasienRiwayatKontrasepsi;
use Illuminate\Http\Request;

class PasienRiwayatKontrasepsiController extends HomeController
{
    public function index()
	{
        $userid = $this->jwt_data['uid'];
        $data = PasienRiwayatKontrasepsi::where('pasienid', $userid)->first();
		return view('frontend.pasien.modal.contraception_history.index', [
            'data' => $data
        ]);
	}

    public function edit()
    {
        $userid = $this->jwt_data['uid'];
        $data = PasienRiwayatKontrasepsi::where('pasienid', $userid)->first();
		return view('frontend.pasien.modal.contraception_history.edit', [
            'data' => $data
        ]);
    }

    public function save()
    {
        $userid = $this->jwt_data['uid'];
        $params['pasienid'] = $userid;
        $params['current_pregnancy'] = request()->input('current_pregnancy');
        $params['before_current_pregnancy'] = request()->input('before_current_pregnancy');
        if (request('id')) {
            PasienRiwayatKontrasepsi::where('id', request('id'))->update($params);
        }else{
            PasienRiwayatKontrasepsi::create($params);
        }
        return response()->json(['status' => 1]);
    }
}

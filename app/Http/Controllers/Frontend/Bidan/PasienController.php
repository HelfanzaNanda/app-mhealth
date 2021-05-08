<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasienProfile;
use App\Models\PasienKehamilan;
use App\Http\Controllers\Controller;
use App\Models\PasienRiwayatKehamilan;
use App\Models\PasienRiwayatKontrasepsi;

class PasienController extends Controller
{
    public function contraception_history($pasien_id)
    {
		$data = PasienRiwayatKontrasepsi::where('pasienid', $pasien_id)->first();
		return view('frontend.bidan.pasien.modal.contraception_history.index', [
            'data' => $data
        ]);
    }

    public function history_current_pregnancy($pasien_id)
    {
        $data = PasienKehamilan::where('pasienid', $pasien_id)->orderBy('id', 'desc')->first();
		return view('frontend.bidan.pasien.modal.history_current_pregnancy.index', [
			'data' => $data
		]);
    }

    public function history_prev_pregnancy($pasien_id)
    {
        $datas = PasienRiwayatKehamilan::where('pasienid', $pasien_id)
		->orderBy('tanggal', 'desc')->get();
		return view('frontend.bidan.pasien.modal.history_prev_pregnancy.index', [
			'datas' => $datas
		]);
    }

    public function identity($pasien_id)
    {
        $data = User::withAddress()->where('id', $pasien_id)->first();
        $profile = PasienProfile::where('pasienid',$data->id)->first();
        return view('frontend.bidan.pasien.modal.identity.index',[
            'data'=>$profile,
            'user'=> $data
        ]);
    }
}

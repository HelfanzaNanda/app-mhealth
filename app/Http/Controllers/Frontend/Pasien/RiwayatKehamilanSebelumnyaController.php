<?php

namespace App\Http\Controllers\Frontend\Pasien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PasienRiwayatKehamilan;

class RiwayatKehamilanSebelumnyaController extends Controller
{
    public function index()
	{
		$userid = $this->jwt_data['uid'];
		$datas = PasienRiwayatKehamilan::where('pasienid', $userid)
		->orderBy('tanggal', 'desc')->get();
		return view('frontend.pasien.modal.history_prev_pregnancy.index', [
			'datas' => $datas
		]);
	}

	public function create()
	{
		return view('frontend.pasien.modal.history_prev_pregnancy.create');
	}

	public function store(Request $request)
	{
		$userid = $this->jwt_data['uid'];
		$params = $request->all();
		$params['pasienid'] = $userid;
		unset($params['_token']);
		PasienRiwayatKehamilan::create($params);
		return response()->json(['status'=>1]);
	}
}

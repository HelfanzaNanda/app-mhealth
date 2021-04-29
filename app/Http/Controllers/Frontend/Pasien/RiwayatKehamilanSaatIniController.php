<?php

namespace App\Http\Controllers\Frontend\Pasien;

use Illuminate\Http\Request;
use App\Models\PasienKehamilan;
use App\Http\Controllers\Controller;

class RiwayatKehamilanSaatIniController extends Controller
{
    public function index()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->firstOrFail();
		return view('frontend.pasien.modal.history_current_pregnancy.index', [
			'data' => $data
		]);
	}

	public function edit()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->firstOrFail();
		return view('frontend.pasien.modal.history_current_pregnancy.edit', [
			'data' => $data
		]);
	}

	public function update(Request $request, $id)
	{
		$params = $request->all();
		unset($params['_token']);
		$data = PasienKehamilan::where('id', $id)->first();
		$data->update($params);
		return response()->json(['status'=>1]);
	}
}

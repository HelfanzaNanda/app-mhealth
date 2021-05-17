<?php

namespace App\Http\Controllers\Frontend\Pasien;

use Illuminate\Http\Request;
use App\Models\PasienKehamilan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;

class RiwayatKehamilanSaatIniController extends HomeController
{
    public function index()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->first();
		return view('frontend.pasien.modal.history_current_pregnancy.index', [
			'data' => $data
		]);
	}

	public function edit()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->first();
		return view('frontend.pasien.modal.history_current_pregnancy.edit', [
			'data' => $data
		]);
	}

	public function update(Request $request, $id = null)
	{
		$params = $request->all();
		unset($params['_token']);
		if ($id) {
			PasienKehamilan::where('id', $id)->update($params);
		}else{
			$userid = $this->jwt_data['uid'];
			$params['pasienid'] = $userid;
			PasienKehamilan::create($params);
		}
		
		return response()->json(['status'=>1]);
	}
}

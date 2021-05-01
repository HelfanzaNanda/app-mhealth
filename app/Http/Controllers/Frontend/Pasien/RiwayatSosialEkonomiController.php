<?php

namespace App\Http\Controllers\Frontend\Pasien;

use Illuminate\Http\Request;
use App\Models\PasienRiwayatSosial;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;

class RiwayatSosialEkonomiController extends HomeController
{
    public function index()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienRiwayatSosial::where('pasienid', $userid)->firstOrFail();
		return view('frontend.pasien.modal.socioeconomic_history.index', [
			'data' => $data
		]);
	}

	public function edit()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienRiwayatSosial::where('pasienid', $userid)->first();
		return view('frontend.pasien.modal.socioeconomic_history.edit', [
			'data' => $data ?? null 
		]);
	}

	public function update(Request $request, $id = null)
	{
		
		$userid = $this->jwt_data['uid'];
		$params = $request->all();
		unset($params['_token']);
		$params['pasienid'] = $userid;
		if ($id == null) {
			PasienRiwayatSosial::create($params);
		}else{
			PasienRiwayatSosial::where('id', $id)->update($params);
		}
		return response()->json(['status'=>1]);
	}
}

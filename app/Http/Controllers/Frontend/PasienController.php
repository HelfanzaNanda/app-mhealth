<?php

namespace App\Http\Controllers\Frontend;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\PromosiKesehatan;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\PasienDiaryKehamilan;
use App\Models\PasienRiwayatKesehatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasienController extends HomeController
{
	public function home()
	{
		$userID = $this->jwt_data['uid'];
		$user = User::where('id', $userID)
		->where('lat', '!=', null)
		->where('lng', '!=', null)->first();
		$promots = PromosiKesehatan::all();
		$isGeoLocation = $user ? true : false;
		return view('frontend.pasien.home.index', [
			'isGeoLocation' => $isGeoLocation,
			'promots' => $promots
		]);
	}

	//pasien update lat lng
	public function updateLatLng(Request $request)
	{
		//unset($request->_token);
		$userID = $this->jwt_data['uid'];
		User::where('id', $userID)->update($request->all());
		return response()->json(['status'=>1]);
	}


	public function health_education_get_content()
	{
		PromosiKesehatan::orderBy('date', 'DESC')->get();

		return view('frontend.pasien.health_education.__items', ['data' => $data]);
	}

	public function diary()
	{
		$userID = $this->jwt_data['uid'];
		$data = PasienDiaryKehamilan::where('pasienid', $userID)->whereDate('created_at', Carbon::today())->first();
		// dd($data);
		return view('frontend.pasien.modal.diary.index', ['data' => $data]);
	}
	public function health_records()
	{
		return view('frontend.pasien.modal.health_records.index');
	}
	
	public function pregnancy_test()
	{
		return view('frontend.pasien.modal.pregnancy_test.index');
	}

	public function contraception_history()
	{
		return view('frontend.pasien.modal.contraception_history.index');
	}

	public function health_history()
	{
		$userID = $this->jwt_data['uid'];
		$data = PasienRiwayatKesehatan::where('pasienid', $userID)->get();
		return view('frontend.pasien.modal.health_history.index', ['data' => $data]);
	}
}

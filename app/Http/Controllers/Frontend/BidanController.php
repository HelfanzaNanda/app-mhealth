<?php

namespace App\Http\Controllers\Frontend;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\BidanPasien;
use App\Models\PasienProfile;

class BidanController extends HomeController
{
	public function home()
	{
		return view('frontend.bidan.home.index');
	}
	public function visit()
	{
		$userID = $this->jwt_data['uid'];
		$data = BidanPasien::where('bidanid', $userID)->get();
		//$data = PasienProfile::all();
		return view('frontend.bidan.visit.index', ['data' => $data]);
	}
}

<?php

namespace App\Http\Controllers\Frontend;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\PasienProfile;

class BidanController extends HomeController
{
	public function home()
	{
		return view('frontend.bidan.home.index');
	}
	public function visit()
	{
		$data = PasienProfile::all();
		return view('frontend.bidan.visit.index', ['data' => $data]);
	}
}

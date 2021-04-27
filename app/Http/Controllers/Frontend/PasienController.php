<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\PromosiKesehatan;
use App\Http\Controllers\Frontend\HomeController;
class PasienController extends HomeController
{
	public function home(){
		return view('frontend.pasien.home.index');
	}


	public function health_education_get_content(){
		PromosiKesehatan::orderBy('date','DESC')->get();

		return view('frontend.pasien.health_education.__items',['data'=>$data]);
	}




	public function diary(){
		return view('frontend.pasien.modal.diary.index');
	}
	public function health_records(){
		return view('frontend.pasien.modal.health_records.index');
	}
	public function consultation(){
		return view('frontend.pasien.modal.consultation.index');
	}
	public function pregnancy_test(){
		return view('frontend.pasien.modal.pregnancy_test.index');
	}
}

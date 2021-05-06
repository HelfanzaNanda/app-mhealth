<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\PromosiKesehatan;
use App\Models\PasienProfile;
use App\Models\BidanProfile;
use App\Http\Controllers\FrontendController;
class PromosiKesehatanController extends FrontendController
{
	public function index($role=''){
		return view('frontend.pasien.health_education.index');
	}
	public function detail($id){
		$data = PromosiKesehatan::findOrFail($id);
		return view('frontend.pasien.health_education.detail', [
			'data' => $data
		]);
	}
	public function load_items(){
		$key = request()->input('key');
		$filter = request()->input('filter');
		$items = PromosiKesehatan::where(function($query)use($filter){
			if(!empty($filter)){
				$query->where('title','like',"%$filter%")
						->orWhere('body','like',"%$filter%");
			}
		})->get();


		$result = [
			'all'=>view('frontend.pasien.health_education.__items',['items'=>$items])->render(),
			'recommended'=>view('frontend.pasien.health_education.__items',['items'=>$items])->render(),
			'pregnant'=>view('frontend.pasien.health_education.__items',['items'=>$items])->render(),
			'test'=>view('frontend.pasien.health_education.__items',['items'=>$items])->render(),
			'health'=>view('frontend.pasien.health_education.__items',['items'=>$items])->render()
		];
		return response()->json(['status'=>1,'key'=>$key,'result'=>$result]);
	}
	
}

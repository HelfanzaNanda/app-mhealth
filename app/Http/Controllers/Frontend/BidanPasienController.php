<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\BidanPasien;
use App\Models\PasienProfile;
use App\Models\BidanProfile;
use App\Http\Controllers\FrontendController;
class BidanPasienController extends FrontendController
{
	public function index($role=''){
		return view('frontend.bidan.pasien.index');
	}
	public function detail($role=''){
		return view('frontend.bidan.pasien.detail');
	}
	public function insert(){
		return view('frontend.bidan.pasien.modal.insert');
	}
	public function load_items(){
		$key = request()->input('key');
		$filter = request()->input('filter');
		$items = BidanPasien::with('pasien')
				->whereHas('pasien',function($query)use($filter){
					if(!empty($filter)){
						$query->where('nama','like',"%$filter%")
								->orWhere('nik','like',"%$filter%");
					}
				})
				->join('pasien_profile','pasien_profile.pasienid','bidan_pasien.pasienid')
				->orderBy('pasien_profile.nama','ASC')
				->get();


		$result = view('frontend.bidan.pasien.__items',['items'=>$items])->render();
		return response()->json(['status'=>1,'key'=>$key,'result'=>$result]);
	}
	public function save(){
		$id = $this->jwt_data['uid'];
		$pasienid=decrypt(request()->input('encrypted'));
		BidanPasien::insert([
			'bidanid'=>$id,
			'pasienid'=>$pasienid,
			'created_at'=>date("Y-m-d H:i:s")
		]);
		return response()->json(['status'=>1]);
	}
	
}

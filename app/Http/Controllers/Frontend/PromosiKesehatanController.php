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
use App\Models\Kategori;

class PromosiKesehatanController extends FrontendController
{
	public function index($role=''){
		$categories = Kategori::all();
		return view('frontend.pasien.health_education.index', [
			'categories' => $categories
		]);
	}
	public function detail($id){
		$data = PromosiKesehatan::findOrFail($id);
		return view('frontend.pasien.health_education.detail', [
			'data' => $data
		]);
	}

	public function load_items()
	{
		$search = request()->input('search');
		$kategori_id = request()->input('category');
		$recommended = request()->input('recommended');
		$items = PromosiKesehatan::with('kategori')
		->where(function($query)use($search , $recommended, $kategori_id){
			if(!empty($search)){
				$query->where('title','like',"%$search%")
						->orWhere('body','like',"%$search%");
			}
			if ($recommended) {
				$query->where('recommended', $recommended);
			}
			if ($kategori_id) {
				$query->where('kategori_id', $kategori_id);
			}
		})
		->get();

		return json_encode($items);

	}
}

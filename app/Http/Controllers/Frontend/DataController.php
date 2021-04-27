<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PromosiKesehatan;
use App\Models\PasienProfile;
use App\Models\BidanProfile;
use App\Http\Controllers\Controller;
class DataController extends Controller
{
	public function kabupaten(){
		$provinsiId = request()->input('provinsiid');
		$result="<option value=''>Pilih Kabupaten</option>";

		$kabupaten = Kabupaten::where('provinsiId',$provinsiId)->orderBy('kabupatenName','ASC')->get();
		foreach ($kabupaten as $row) {
			$result.="<option value='".$row->kabupatenId."'>".$row->kabupatenName."</option>";
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function kecamatan(){
		$kabupatenId = request()->input('kabupatenid');
		$result="<option value=''>Pilih Kecamatan</option>";

		$kecamatan = Kecamatan::where('kabupatenId',$kabupatenId)->orderBy('kecamatanName','ASC')->get();
		foreach ($kecamatan as $row) {
			$result.="<option value='".$row->kecamatanId."'>".$row->kecamatanName."</option>";
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function kelurahan(){
		$kecamatanId = request()->input('kecamatanid');
		$result="<option value=''>Pilih Kelurahan</option>";

		$kelurahan = Kelurahan::where('kecamatanId',$kecamatanId)->orderBy('kelurahanName','ASC')->get();
		foreach ($kelurahan as $row) {
			$result.="<option value='".$row->kelurahanId."'>".$row->kelurahanName."</option>";
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}

	public function pasien(){
		$username = request()->input('username');
		$pasien = PasienProfile::whereHas('user',function($query)use($username){
			$query->where('email',$username);
		})->orWhere('nik',$username)->first();
		if(!$pasien){
			return response()->json(['status'=>0,'msg'=>'<p class="text-center">Tidak ditemukan</p>']);
		}
		$result = view('frontend.bidan.pasien.__preview',['data'=>$pasien])->render();
		return response()->json(['status'=>1,'result'=>$result,'encrypted'=>encrypt($pasien->pasienid)]);
	}
}

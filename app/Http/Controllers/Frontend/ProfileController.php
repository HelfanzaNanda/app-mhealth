<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\PromosiKesehatan;
use App\Models\Provinsi;
use App\Models\PasienProfile;
use App\Models\BidanProfile;
use App\Http\Controllers\FrontendController;
class ProfileController extends FrontendController
{
	public function index($role=''){
		$data=User::where('id',$this->jwt_data['uid'])->first();
		if($data->role=='pasien'){
			return view('frontend.pasien.profile.index',['data'=>$data]);
		}
	}

	public function identity(){
		$data=User::where('id',$this->jwt_data['uid'])->first();
		if($data->role=='pasien'){
			$profile = PasienProfile::withAddress()->where('pasienid',$data->id)->first();
			// var_dump($profile);
			return view('frontend.pasien.profile.identity',['data'=>$profile]);
		}
	}
	public function edit(){
		$data=User::where('id',$this->jwt_data['uid'])->first();
		if($data->role=='pasien'){
			$profile = PasienProfile::where('pasienid',$data->id)->first();
			$list_provinsi = Provinsi::orderBy('provinsiName','ASC')->get();
			return view('frontend.pasien.profile.edit',['data'=>$profile, 'list_provinsi'=>$list_provinsi]);
		}
	}

	public function update(){
		$userid = $this->jwt_data['uid'];
		$data=User::where('id',$userid)->first();
		User::where('id',$userid)->update([
			'fullname'=>request()->input('nama')
		]);

		PasienProfile::where('pasienid',$userid)->update([
			'nama'=>request()->input('nama'),
			'tempatlahir'=>request()->input('tempatlahir'),
			'tanggallahir'=>request()->input('tanggallahir'),
			'agama'=>request()->input('agama'),
			'provinsiid'=>request()->input('provinsiid'),
			'kabupatenid'=>request()->input('kabupatenid'),
			'kecamatanid'=>request()->input('kecamatanid'),
			'kelurahanid'=>request()->input('kelurahanid'),
			'alamat'=>request()->input('alamat'),
			'keluarga'=>request()->input('keluarga'),
			'pendidikan'=>request()->input('pendidikan'),
			'nohp'=>request()->input('nohp'),
			'pekerjaan'=>strtoupper(request()->input('pekerjaan')),
			'suku'=>strtoupper(request()->input('suku')),

		]);
		return response()->json(['status'=>1]);
	}
	
}

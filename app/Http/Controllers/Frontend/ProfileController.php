<?php

namespace App\Http\Controllers\Frontend;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\BidanProfile;
use Illuminate\Http\Request;
use App\Models\PasienProfile;
use App\Http\Controllers\FrontendController;

class ProfileController extends FrontendController
{
	public function index($role=''){
		$data=User::where('id',$this->jwt_data['uid'])->first();
		if($data->role=='pasien'){
			return view('frontend.pasien.profile.index',['data'=>$data]);
		}else{
			return view('frontend.bidan.profile.index',[
				'data'=>$data
			]);
		}
	}

	public function identity(){
		$data = User::withAddress()->where('id',$this->jwt_data['uid'])->first();
		if($data->role=='pasien'){
			$profile = PasienProfile::where('pasienid',$data->id)->first();
			//$profile = User::withAddress()->where('id',$data->id)->first();
			return view('frontend.pasien.profile.identity',[
				'data'=>$profile,
				'user'=> $data
			]);
		}else{
			return view('frontend.bidan.profile.identity',[
				'user'=> $data
			]);
		}
	}
	public function edit(){
		$data=User::where('id',$this->jwt_data['uid'])->first();
		$list_provinsi = Provinsi::orderBy('provinsiName','ASC')->get();
		if($data->role=='pasien'){
			$profile = User::where('id',$data->id)->first();
			return view('frontend.pasien.profile.edit',[
				'data'=>$profile, 
				'list_provinsi'=>$list_provinsi,
				'user' => $data
			]);
		}else{
			return view('frontend.bidan.profile.edit',[
				'list_provinsi'=>$list_provinsi,
				'data' => $data
			]);
		}
	}

	public function update(){
		$userid = $this->jwt_data['uid'];
		$data=User::where('id',$userid)->first();
		User::where('id',$userid)->update([
			'fullname'=>request()->input('nama'),
			'alamat'=>request()->input('alamat'),
			'nohp'=>request()->input('nohp'),
			'provinsiid'=>request()->input('provinsiid'),
			'kabupatenid'=>request()->input('kabupatenid'),
			'kecamatanid'=>request()->input('kecamatanid'),
			'kelurahanid'=>request()->input('kelurahanid'),
		]);

		PasienProfile::where('pasienid',$userid)->update([
			'tempatlahir'=>request()->input('tempatlahir'),
			'tanggallahir'=>request()->input('tanggallahir'),
			'agama'=>request()->input('agama'),
			'keluarga'=>request()->input('keluarga'),
			'pendidikan'=>request()->input('pendidikan'),
			'pekerjaan'=>strtoupper(request()->input('pekerjaan')),
			'suku'=>strtoupper(request()->input('suku')),

		]);
		return response()->json(['status'=>1]);
	}

	public function updateBidan(){
		$userid = $this->jwt_data['uid'];
		User::where('id',$userid)->update([
			'sipb'=>request()->input('sipb'),
			'fullname'=>request()->input('nama'),
			'alamat'=>request()->input('alamat'),
			'nohp'=>request()->input('nohp'),
			'provinsiid'=>request()->input('provinsiid'),
			'kabupatenid'=>request()->input('kabupatenid'),
			'kecamatanid'=>request()->input('kecamatanid'),
			'kelurahanid'=>request()->input('kelurahanid'),
		]);
		return response()->json(['status'=>1]);
	}

	public function showFormChangePassowrd()
	{
		return view('frontend.pasien.profile.change_password');
	}

	public function changePassword(Request $request)
	{

		$request->validate([
			'password' => 'min:6|required|confirmed'
		]);
		$userid = $this->jwt_data['uid'];
		$user = User::where('id',$userid)->first();
		$user->update([
			'password' => md5($request->password)
		]);

		return response()->json(['status'=>1]);
	}
	
}

<?php

namespace App\Http\Controllers\Frontend;
use DB;
use Route;
use Guzzle;
use Requset;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\BidanProfile;
use Illuminate\Http\Request;
use App\Models\PasienProfile;
use App\Models\PasienKehamilan;
use App\Models\PromosiKesehatan;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FrontendController;
use App\Models\PasienRiwayatKehamilan;
use App\Models\PasienRiwayatKesehatan;
use App\Models\PasienRiwayatSosial;

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

	public function history_current_pregnancy()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->firstOrFail();
		return view('frontend.pasien.profile.history_current_pregnancy', [
			'data' => $data
		]);
	}

	public function edit_history_current_pregnancy()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienKehamilan::where('pasienid', $userid)->orderBy('id', 'desc')->firstOrFail();
		return view('frontend.pasien.profile.edit_history_current_pregnancy', [
			'data' => $data
		]);
	}

	public function change_history_current_pregnancy(Request $request, $id)
	{
		$params = $request->all();
		unset($params['_token']);
		$data = PasienKehamilan::where('id', $id)->first();
		$data->update($params);
		return response()->json(['status'=>1]);
	}

	public function history_prev_pregnancy()
	{
		$userid = $this->jwt_data['uid'];
		$datas = PasienRiwayatKehamilan::where('pasienid', $userid)
		->orderBy('tanggal', 'desc')->get();
		return view('frontend.pasien.profile.prev_pregnancy_history', [
			'datas' => $datas
		]);
	}

	public function create_history_prev_pregnancy()
	{
		return view('frontend.pasien.profile.create_prev_pregnancy_history');
	}

	public function store_history_prev_pregnancy(Request $request)
	{
		$userid = $this->jwt_data['uid'];
		$params = $request->all();
		$params['pasienid'] = $userid;
		unset($params['_token']);
		PasienRiwayatKehamilan::create($params);
		return response()->json(['status'=>1]);
	}

	public function socioeconomic_history()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienRiwayatSosial::where('pasienid', $userid)->firstOrFail();
		return view('frontend.pasien.modal.socioeconomic_history.index', [
			'data' => $data
		]);
	}

	public function edit_socioeconomic_history()
	{
		$userid = $this->jwt_data['uid'];
		$data = PasienRiwayatSosial::where('pasienid', $userid)->first();
		return view('frontend.pasien.modal.socioeconomic_history.edit', [
			'data' => $data ?? null 
		]);
	}

	public function update_socioeconomic_history(Request $request, $id = null)
	{
		
		$userid = $this->jwt_data['uid'];
		$params = $request->all();
		unset($params['_token']);
		$params['pasienid'] = $userid;
		if ($id == null) {
			PasienRiwayatSosial::create($params);
		}else{
			PasienRiwayatSosial::where('id', $id)->update($params);
		}
		return response()->json(['status'=>1]);
	}
	
}

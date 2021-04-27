<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;

use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use DB;
use Cache;
use App\Models\User;
use App\Models\BidanProfile;
use App\Models\PasienProfile;
use App\Models\Kunjungan;
use App\Models\Banner;
class UserController extends ApiController
{
	public function login(){
		$username = request()->input('username');
		$password = request()->input('password');

		$user = User::where([
			'email'=>$username,
			'password'=>md5($password),
		]);
		if($user->exists()){
			$userdata = $user->first();
            $payload = [
                'iat' => time(),
                'uid' => $userdata->id,
                'exp' => time() + config('app.TIMEOUT'),
            ];

            $secret = config('app.JWT_SECRET');
            $jwt = Token::customPayload(['payload' => encrypt($payload)], $secret);
            $this->saveJwt($userdata->id,$jwt);
            return response()->json(['status'=>1]);
		}else{
            return response()->json(['status'=>0,'msg'=>'Periksa kembali email dan password']);	
		}
	}
	public function inbox_list(){
		$userid=$this->jwt_data['userdata']->id;
		$data = Inbox::select('toid','fromid')
				->where('fromid',$userid)
				->orWhere('toid',$userid)
				->groupBy('toid','fromid')
				->get();
		return response()->json(['status'=>1,'result'=>$data]);
	}

	public function inbox_get(){
		$userid=$this->jwt_data['userdata']->id;
		$data = Inbox::where('fromid',$userid)
				->orWhere('toid',$userid)
				->get();
		return response()->json(['status'=>1,'result'=>$data]);
	}

	public function inbox_send(){
		$fromid=$this->jwt_data['userdata']->id;
		$toid=request()->input('to');
		$text=request()->input('text');
		Inbox::insert([
			'fromid'=>$fromid,
			'toid'=>$toid,
			'text'=>$text,
			'created_at'=>date("Y-m-d H:i:s"),
			'status'=>'sent'
		]);
		return response()->json(['status'=>1]);
	}

	protected function save_bidan($userid){
		$nama = request()->input('nama');
		$sipb = request()->input('sipb');
		$alamat = request()->input('alamat');
		$kelurahanid = request()->input('kelurahanid');
		$kecamatanid = request()->input('kecamatanid');
		$kabupatenid = request()->input('kabupatenid');
		$data = [
				'bidanid'=>$userid,
				'nama'=>$nama,
				'sipb'=>$sipb,
				'alamat'=>$alamat,
				'kelurahanid'=>$kelurahanid,
				'kecamatanid'=>$kecamatanid,
				'kabupatenid'=>$kabupatenid,
			];
		if(BidanProfile::where('bidanid',$userid)->exists()){
			BidanProfile::where('bidanid',$userid)->update($data);
		}else{
			BidanProfile::insertGetId($data);
		}
		return response()->json(['status'=>1]);
	}
	protected function save_pasien($userid){
		$nama = request()->input('nama');
		$tempatlahir = request()->input('tempatlahir');
		$tanggallahir = request()->input('tanggallahir');
		$agama = request()->input('agama');
		$alamat = request()->input('alamat');
		$kelurahanid = request()->input('kelurahanid');
		$kecamatanid = request()->input('kecamatanid');
		$kabupatenid = request()->input('kabupatenid');
		$keluarga = request()->input('keluarga');
		$nohp = request()->input('nohp');
		$pendidikan = request()->input('pendidikan');
		$pekerjaan = request()->input('pekerjaan');
		$suku = request()->input('suku');
		$suami_nama = request()->input('suami_nama');
		$suami_umur = request()->input('suami_umur');
		$suami_pendidikan = request()->input('suami_pendidikan');
		$suami_pekerjaan = request()->input('suami_pekerjaan');
		$suami_alamat = request()->input('suami_alamat');
		$suami_goldarah = request()->input('suami_goldarah');
		$nik = request()->input('nik');

		$data = [
				'pasienid'	=> $userid,
				'nama'	=> $nama,
				'tempatlahir'	=> $tempatlahir,
				'tanggallahir'	=> $tanggallahir,
				'agama'	=> $agama,
				'alamat'	=> $alamat,
				'kelurahanid'	=> $kelurahanid,
				'kecamatanid'	=> $kecamatanid,
				'kabupatenid'	=> $kabupatenid,
				'keluarga'	=> $keluarga,
				'nohp'	=> $nohp,
				'pendidikan'	=> $pendidikan,
				'pekerjaan'	=> $pekerjaan,
				'suku'	=> $suku,
				'suami_nama'	=> $suami_nama,
				'suami_umur'	=> $suami_umur,
				'suami_pendidikan'	=> $suami_pendidikan,
				'suami_pekerjaan'	=> $suami_pekerjaan,
				'suami_alamat'	=> $suami_alamat,
				'suami_goldarah'	=> $suami_goldarah,
				'nik'	=> $nik,
				'foto'	=> $foto,

			];
		if(PasienProfile::where('pasienid',$userid)->exists()){
			PasienProfile::where('pasienid',$userid)->update($data);
		}else{
			PasienProfile::insertGetId($data);
		}
		return response()->json(['status'=>1]);
	}
	public function save_profile_pasien(){
		$userid = $this->jwt_data['userdata']->id;
		$this->save_pasien($userid);
	}
	public function save_profile_bidan(){
		$userid = $this->jwt_data['userdata']->id;
		$this->save_bidan($userid);
	}
	public function register(){
		$role = request()->input('role');
		$username = request()->input('username');
		$password = request()->input('password');
		$confirm_password = request()->input('confirm_password');

		if(User::where('email',$username)->exists()){
			return response()->json(['status'=>0,'msg'=>'Email sudah digunakan']);
		}

		if($password!==$confirm_password){
			return response()->json(['status'=>0,'msg'=>'Periksa kembali konfirmasi password']);
		}
		if(!in_array($role, ['bidan','pasien'])){
			return response()->json(['status'=>0,'msg'=>'Gagal!']);
		}
		$userid = User::insertGetId([
			'email'=>$username,
			'password'=>md5(str)
		]);
		if(!$userid){
			return response()->json(['status'=>0,'msg'=>'Gagal!']);
		}
		if($role=='pasien'){
			return $this->save_pasien($userid);
		}elseif($role=='bidan'){
			return $this->save_bidan($userid);
		}
	}
	public function get_banner(){
		return response()->json(['status'=>1, 'result'=>Banner::get()]);
	}
}

<?php

namespace App\Http\Controllers\Frontend;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Models\PasienProfile;
use App\Models\BidanProfile;
use App\Http\Controllers\FrontendController;
class AuthController extends FrontendController
{
	public function login($role=''){
		return view('frontend.auth.login',['role'=>$role]);
	}
	public function logout(){
        $this->__logout();
        return redirect()->to(route('index'));
	}
	public function welcome(){
		return view('frontend.auth.welcome');
	}

	public function register($role=''){
		return view('frontend.auth.register',['role'=>$role]);
	}
	public function login_submit($role=''){
		$email = request()->input('email');
		$password = request()->input('password');
		$user = User::where(['email'=>$email,'password'=>md5($password)]);
		if($user->exists()){
			$this->__login($user->first());
			return response()->json(['status'=>1]);
		}
		return response()->json(['status'=>0,'msg'=>'Email atau pasword salah']);
	}
	public function register_submit($role=''){
		$fullname = request()->input('fullname');
		$email = request()->input('email');
		$password = request()->input('password');
		$confirm_password = request()->input('confirm_password');
		$nik = request()->input('nik');
		$sipb = request()->input('sipb');
		if($password!==$confirm_password){
			return response()->json(['status'=>0,'msg'=>'Periksa kembali konfirmasi kata sandi kamu']);
		}
		$user = User::where('email',$email);
		if($user->exists()){
			$user=$user->first();
			$exists=true;
			if($user->role=='pasien'){
				$exists=PasienProfile::where('pasienid',$user->id)->exists();
			}elseif($user->role=='bidan'){
				$exists=BidanProfile::where('bidanid',$user->id)->exists();
			}
			if($exists){
				return response()->json(['status'=>0,'msg'=>'Email sudah terdaftar']);
			}
		}
		if(!$user){
			$userid = User::insertGetId([
				'fullname'=>$fullname,
				'email'=>$email,
				'password'=>md5($password),
				'role'=>$role
			]);
		}else{
			User::where('id',$user->id)->update([
				'fullname'=>$fullname,
				'email'=>$email,
				'password'=>md5($password),
				'role'=>$role
			]);
			$userid = $user->id;
		}
		if($role=='pasien'){
			PasienProfile::insert([
				'pasienid'=>$userid,
				'nama'=>$fullname,
				'nik'=>$nik,
			]);
		}

		if($role=='bidan'){
			BidanProfile::insert([
				'bidanid'=>$userid,
				'nama'=>$fullname,
				'sipb'=>$sipb,
			]);
		}
		
		return response()->json(['status'=>1]);
	}
	
}

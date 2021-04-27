<?php

namespace App\Http\Controllers;
use Guzzle;
use Requset;
use Route;
use DB;
use ReallySimpleJWT\Token;
class FrontendController extends Controller
{
	public $settings =null;
	public $jwt_data = null;
	function __construct(){
		$except = ['welcome','login','logout','register','register_submit','login_submit'];
		$jwt_data = $this->jwt_data();
		$this->jwt_data=$jwt_data;
		$method = Route::getCurrentRoute()->getActionMethod();
		if(in_array($method, $except)){
			if(!in_array($method,['login_submit','logout'])){
				if(isset($jwt_data['userdata'])){
					if($jwt_data['userdata']->role=='pasien'){
						redirect()->to(route('pasien.home'))->send();
						return;
					}
					if($jwt_data['userdata']->role=='bidan'){
						redirect()->to(route('bidan.home'))->send();
						return;
					}
				}
			}
		}else{

			if(!isset($jwt_data['userdata'])){
				redirect()->to(route('welcome'))->send();
				return;
			}
		}
		$result = DB::table('site_content')->get();
		$data = [];
		foreach ($result as $row) {
			$data[$row->name]=$row->value;
		}
		$this->settings=$data;
		view()->share('__is_logged',(isset($jwt_data['userdata'])));
		view()->share('__userdata',($jwt_data['userdata']??[]));
		view()->share('__settings',$this->settings);
	}
	protected function __login($userdata){
        $payload = [
            'iat' => time(),
            'uid' => $userdata->id,
            'exp' => time() + config('app.TIMEOUT'),
        ];

        $secret = config('app.JWT_SECRET');
        $jwt = Token::customPayload(['payload' => encrypt($payload)], $secret);

        $this->saveJwt($userdata->id,$jwt);
        session()->put('jwt',$jwt);
	}
}

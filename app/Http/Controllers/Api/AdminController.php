<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Helpers\Format_respon as Res;

use ReallySimpleJWT\Token;
use Request;
use DB;

use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\GuzzleException;
class AdminController extends Controller
{
    
    public $mail_vendor = '';
    public $jwt_data = null;
    public $settings = null;
    function __construct(Request $request){
        $this->jwt_data = $this->jwt_data();  
        $r = DB::table('site_content')->get();
        $settings = [];
        foreach ($r as $row) {
            $settings[$row->name]=$row->value;
        }
        $this->settings = $settings;   
        view()->share('__settings',$settings); 
    }    
    public function home(){ 
        $userdata = $this->jwt_data['userdata'];
        $result = [
        ];
        return response()->json(['status'=>1,'result'=>$result]);

    }
    public function check()
    {
        $jwt_data = $this->jwt_data();
        if(!isset($jwt_data['userdata'])){
            return response()->json(['status'=>0,'msg'=>'Not logged in']);
        }
        
        return response()->json(['status'=>1,'msg'=>'Logged in']);
    }
    public function login(){
        $username = request()->input('username');
        $password = request()->input('password');

        $result = DB::table('user')
            ->where('email',$username)
            ->where('password',md5($password));

        if($result->exists()){
            $userdata = $result->first();
            $payload = [
                'iat' => time(),
                'uid' => $userdata->id,
                // 'userdata'=>$userdata,
                'exp' => time() + config('app.TIMEOUT'),
            ];

            $secret = config('app.JWT_SECRET');
            $jwt = Token::customPayload(['payload' => encrypt($payload)], $secret);
            $this->saveJwt($userdata->id,$jwt);
            return response()->json(['status'=>1,'msg'=>'Success','jwt'=>$jwt]);
        }
        return response()->json(['status'=>0,'msg'=>'Invalid login']);
    }
    public function color_save(){
        $colorhex = request()->input('colorhex');
        $name = request()->input('name');
        DB::table('color')->insert(['name'=>$name,'colorhex'=>$colorhex]);
        return response()->json(['status'=>1,'msg'=>'']);
    }

    public function get_update(){
        $userdata = $this->jwt_data['userdata'];
        $new_notification=[];
        $result =[
            'new_notification'=>$new_notification,

        ];

        return response()->json(['status'=>1,'result'=>$result]);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use ReallySimpleJWT\Token;
use ReallySimpleJWT\Exception\ValidateException;
use DB;

class AllowApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $start_time = '';


    public function handle($request, Closure $next)
    {
    	$this->start_time = microtime(true);
    	
    	$path_umum = [''];
    	$path =  $request->route()->getActionMethod();
        #CEK JWT
        $exclude_jwt = ['login','course_list','user_register','user_validate','user_update_password','reset_email','request_reset_password','reset_password','download'];
        
        $exclude_jwt = array_merge($exclude_jwt);
        if(!in_array($path, $exclude_jwt)){            
            $validate_jwt = $this->validate_jwt($request);
            if($validate_jwt !== true){
            	header('Content-Type: application/json');
	            // http_response_code(401);
	            echo json_encode(
	            	[
	            		'status' => false,'message' => 'Invalid JWT',
	            		'data' => ['error' => 'Invalid JWT','errorcode' => 401]
	            	]
	            );
	            
                exit;
            }

            $statusJwt = $this->cekJwt($request);
            
            
            if($statusJwt !== true){
                header('Content-Type: application/json');
                // http_response_code(401);
                echo json_encode(
	            	[
	            		'status' => false,'message' => 'Expired JWT',
	            		'data' => ['error' => 'Expired JWT','errorcode' => 401]
	            	]
	            );
                exit;
            }
        } 
        
        $response = $next($request);
        // $return = $response->content();
        // $length = strlen($return);
        // if($length > 1000){
        // 	$return = json_decode($return,true);
        // 	$return['data'] = 'Data too long : '.$length.' char';
        // 	$return = json_encode($return);
        // }
    	return $response;
    }


    protected function jwt_data($request){
        $token = $request->bearerToken();
        if($token == null){
            $token = '';
        }
        $secret = config('app.JWT_SECRET');
        try {
            $result = Token::getPayload($token, $secret);
        } catch (ValidateException $e) {
            $result = [
                'uid' => '',
                'empCode' => '',
                'token' => ''
            ];
        }
        return $result;
    }

    protected function validate_jwt($request){
        $result = [];

        $token = $request->bearerToken();
        if($token == null){
            $token = '';
        }

        $secret = config('app.JWT_SECRET');
        $result = Token::validate($token, $secret);
        return $result;
    }

    protected function cekJwt($request){
        $token = $request->bearerToken();
        if(!DB::table('user_login')->where(['api_key'=>$token])->exists()){
            return false;
        }

        return true;
    }
}

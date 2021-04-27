<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Format_respon as Res;

use ReallySimpleJWT\Token;
use Request;
use DB;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\GuzzleException;
class Controller extends BaseController
{
    
    public $mail_vendor = '';
    public $jwt_data = null;
    public $is_logged = false;
    public $settings = null;
    function __construct(Request $request){
        $this->jwt_data = $this->jwt_data();
        if(isset($this->jwt_data['userdata'])){
            $this->is_logged=true;
        }  
        $r = DB::table('site_content')->get();
        $settings = [];
        foreach ($r as $row) {
            $settings[$row->name]=$row->value;
        }
        $this->settings = $settings;   
        view()->share('__settings',$settings); 
    }    

    public function send_push_notification($to='',$title='',$content=''){
        $content = [
            "en" => $content
        ];
        $heading = [
            'en' => $title
        ];
        // print_r($this->settings);
        // exit();
        $fields = array(
            'app_id' => $this->settings['onesignal_id'],
            'headings' => $heading,
            'contents' => $content
        );
        if(!empty($to)){
            $fields['filters']= [
                [
                    "field" => "tag",
                    "key"=>"email",
                    "relation"=>"=",
                    "value" => $to
                ],
            ];
        }else{
            $fields['included_segments'] = ["Active Users", "Inactive Users"];
        }
        
        
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$this->settings['onesignal_key']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }



    public function send_email_template($to,$subject,$template_name,$replace=[]){

        $html = $this->__get_email_template($template_name,$replace);
        
        return $this->send_email($to,$subject,$html);
    }
    public function __get_email_template($name='',$replace=[]){
        $template=$this->settings['tmp_'.$name];
        foreach ($replace as $key => $value) {
            $template = str_replace($key, $value, $template);
        }
        return $template;
    }
    
    public function send_email($to,$subject,$content,$priority='2'){

        return mail($to,$subject,$content,[
            'From'=>'noreply@ethnicindia.co',
            'MIME-Version'=>'1.0',
            'Content-type'=>'text/html; charset=iso-8859-1',
            'X-Priority'=>(string)$priority,
            'Reply-To'=>'noreply@ethnicindia.co',
            'X-Mailer'=>'PHP/'.phpversion(),
        ],'-fnoreply@ethnicindia.co');
        // return $this->call_elastic('send',[
        //     'from'=>$this->settings['elastic_account'],
        //     'fromName'=>'Ethnic India',
        //     'subject'=>$subject,
        //     'to'=>$to,
        //     'bodyHtml'=>view('email.template',['content'=>$content,'title'=>$subject,'settings'=>$this->settings])->render(),
        // ]);
    }
    public function __logout(){
        $token = session()->get('jwt');
        DB::table('user_login')->where('api_key',$token)->delete();
        session()->flush();
    }
    public function jwt_data(){
        $token = session()->get('jwt');
        if($token == null){
            $token = '';
        }
        $secret = config('app.JWT_SECRET');
        try {
            $result = Token::getPayload($token, $secret);
            $result = decrypt($result['payload']);
            $user = DB::table('user')->where('id',$result['uid'])->first();
            $result['userdata']=$user;
        } catch (\ReallySimpleJWT\Exception\ValidateException $e) {
            $result = [
                'uid' => '',
                'userdata'=>null,
            ];
        }
        return $result;
    }
    public function saveJwt($id,$jwt){
        // if(DB::table('user_login')->where(['id'=>$id])->exists()){
            // DB::table('user_login')
                // ->where('id',$id)
                // ->update(['api_key'=>$jwt]);
        // }else{
        DB::table('user_login')
            ->insert([
                'id'=>$id,
                'api_key'=>$jwt
            ]);
        // }
        session()->put('jwt',$jwt);
    }
    public function check()
    {
        $jwt_data = $this->jwt_data();
        if(!isset($jwt_data['userdata'])){
            return response()->json(['status'=>0,'msg'=>'Not logged in']);
        }
        // if($jwt_data['exp']<time()){
        //     return response()->json(['status'=>0,'msg'=>'Login expired']);
        // }
        
        // $jwt_data['exp'] = time() + config('app.TIMEOUT');

        // $secret = config('app.JWT_SECRET');
        // $jwt = Token::customPayload(['payload' => encrypt($jwt_data)], $secret);
        // print_r($jwt_data);
        // $this->saveJwt($jwt_data['uid'],$jwt);
        
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

    public function get_product_images_single($product){
        $products[]=$product;
        $products=$this->get_product_images(collect($products));
        return $products[0];
    }
    public function get_product_images($products){
        $ids = $products->pluck('id');
        $images=[];
        if(count($ids)>0){
            $images_list = DB::table('contact_image')
                    ->join('image','image.id','contact_image.imageid')
                    ->select('image.*','contact_image.productid')
                    ->whereIn('productid',$ids)->get();
                    // print_r($images_list);
            $images=[];
            foreach ($images_list as $row) {
                $images[$row->productid][]=$row->preview;
            }
        }
        foreach ($products as &$row) {
            $row->images = isset($images[$row->id])?$images[$row->id]:'';
        }
        return $products;
    }
    public function home(){
        $year = date('Y');
        $data = [
            'customerTotal'=>DB::table('user')->count(),
            'topRatedProduct'=>DB::table('contact')->select("contact.name","contact.slug","contact.sku")->where('is_deleted',0)->orderBy('rating','DESC')->limit(5)->get(),
            // 'popularProduct'=>DB::table('contact')->where('is_deleted',0)->orderBy('rating')->limit(10)->get(),
            // 'trendingProduct'=>DB::table('contact')->where('is_deleted',0)->orderBy('views')->limit(5)->get(),
            'mostViewedProduct'=>DB::table('contact')->select("contact.name","contact.slug","contact.sku")->where('is_deleted',0)->orderBy('views','DESC')->limit(5)->get(),    
            'mostBoughtProduct'=>DB::table('contact')->select("contact.name","contact.slug","contact.sku",DB::raw("(SELECT COUNT(*) FROM checkout_item WHERE checkout_item.productid=contact.id) as checkout_count"))->where('is_deleted',0)->orderBy('checkout_count','DESC')->limit(5)->get(),

            'averageOrderChart'=>'',
            'salesConvertionRate'=>'',
            'addCartRate'=>'',
            'checkoutRate'=>'',
            'wishlistRate'=>'',  
            'repeatCostumerRate'=>'',  
            'refundRate'=>'', 
            'websiteTraffict'=>$websiteTraffict,
            'websiteTraffictDevice'=>$websiteTraffictDevice,    
        ];
        return response()->json(['status'=>1,'result'=>$data]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use ReallySimpleJWT\Token;
use Request;
use DB;
use Cache;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\GuzzleException;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $mail_vendor = '';
    public $jwt_data = null;
    public $settings = null;

    function __construct(Request $request){

        $this->jwt_data = $this->jwt_data();      
        $r = DB::table('site_content')->get();
        // echo "string";
        $settings = [];
        foreach ($r as $row) {
            $settings[$row->name]=$row->value;
        }
        $this->settings = $settings;  
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
    public function get_product_images_single($product){
        $products[]=$product;
        $products=$this->get_product_images(collect($products));
        return $products[0];
    }
    public function get_product_images($products){
        $ids = $products->pluck('id');
        $userdata = $this->jwt_data['userdata'];
        if(count($ids)>0){
            $images_list = Cache::rememberForever('productimage'.serialize($ids), function ()use($ids) {
                return DB::table('contact_image')
                        ->select('image.preview','image.image')
                        ->join('image','image.id','contact_image.imageid')
                        ->select('image.*','contact_image.productid')
                        ->whereIn('productid',$ids)
                        ->get();
            });

            $images=[];
            foreach ($images_list as $row) {
                $images[$row->productid][]=$row;
            }
        }
        $uuid=request()->input('uuid');
        // print_r($uuid);
        if($userdata){
            $uuid=$userdata->id;
        }
        $latest_date['product']=Cache::rememberForever('latest.product.date', function () {
            return DB::table('contact')
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as latest"))
            ->where('is_deleted',0)
            ->where('is_active',1)
            ->where('type','product')
            ->orderBy('created_at','DESC')->first();
        });
        $latest_date['fabric']=Cache::rememberForever('latest.product.date', function ()use($ids) {
            return DB::table('contact')
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as latest"))
            ->where('is_deleted',0)
            ->where('is_active',1)
            ->where('type','fabric')
            ->orderBy('created_at','DESC')->first();
        });
        $wishlist_ids = DB::table('user_wishlist')->where('customerid',$uuid)->pluck('productid')->toArray();
        foreach ($products as &$row) {
            if(isset($row->id)){
                $row->images = isset($images[$row->id])?$images[$row->id]:[''];
                if(isset($row->has_color_variant)){
                    $row->is_wishlist = in_array($row->id, $wishlist_ids);
                    $row->wishlist=$wishlist_ids;
                    $row->is_variant=($row->has_color_variant==1  || $row->has_size_variant==1)?1:0;

                    $row->is_new=false;
                    if(!is_array($row->size)){
                        $row->size=explode(',',$row->size);
                    }
                    if(!isset($latest_date[$row->type])){
                        $row->is_new=false;
                    }else{
                        if(date("Y-m-d",strtotime($row->created_at))==$latest_date[$row->type]->latest){
                            $row->is_new=true;
                        }
                    }
                }
            }
        }
        return $products;
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
    public function __send_email_activation($email){
        $link = $this->settings['url']."/activate/".encrypt($email);
        if(!empty($email)){
            if(DB::table('user')->where('email',$email)->exists()){
                $code = rand(111111,999999);
                DB::table('user')
                    ->where('email',$email)
                    ->update(['otp'=>$code,'otp_exp'=>(time()+(60*30))]);

                $customer = DB::table('user')->where('email',$email)->first();
                $this->send_email_template($email,
                    'Account Activation',
                    "activation",
                    [
                        "{{CUSTOMER_NAME}}"=>$customer->fullname,
                        "{{ACTIVATION_CODE}}"=>$code,
                        "{{ACTIVATION_LINK}}"=>"<a href='".$link."'>Click Here</a>"
                    ]);
                return $link;
                
            }
        }
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
    public function call_elastic($api,$parameter = []){

        $client = new Client();
        $result=null;
        try {
            $param =  [
                
                'verify' => false,
            ];
            $parameter['apikey']=$this->settings['elastic_key'];
            // print_r($parameter);
            $param['form_params']=$parameter;
            $response = $client->request('POST', 'https://api.elasticemail.com/v2/email/'.$api, $param);
            $result_json = $response->getBody()->getContents();
            $result = json_decode($result_json);  
            if(!$result){
                $result=$result_json;
            }
            // print_r($result);
        } catch (GuzzleException $e) {
            $result_json = $e->getResponse()->getBody()->getContents();
            // print_r($result_json);
            $result = json_decode($result_json);  

        }
        return $result; 
        
    }
    public function call_mailchimp($api,$parameter = []){

        $client = new Client();
        $result=null;
        try {
            $param =  [
                'headers'=>[
                    'Content-Type'=>'application/json'
                ],
                'verify' => false,
            ];
            $parameter['key']=$this->settings['mailchimp_key'];
            // print_r($parameter);
            $param['body']=json_encode($parameter);
            $response = $client->request('POST', 'https://mandrillapp.com/api/1.0/'.$api, $param);
            $result_json = $response->getBody()->getContents();
            $result = json_decode($result_json);  
            if(!$result){
                $result=$result_json;
            }
            // print_r($result);
        } catch (GuzzleException $e) {
            $result_json = $e->getResponse()->getBody()->getContents();
            // print_r($result_json);
            $result = json_decode($result_json);  

        }
        return $result; 
        
    }
    
    public function call_delhivery($api,$parameter = []){
        $client = new Client();
        $result=null;
        try {
            $param =  [
                
                'headers'=>[
                    'Authorization'=> "Token ".$this->settings['delhivery_key'],
                ],
                'verify' => false,
            ];

            $param['form_params']=$parameter;
            $response = $client->request('GET', 'https://track.delhivery.com/c/api/'.$api, $param);
            $result_json = $response->getBody()->getContents();
            $result = json_decode($result_json);  
            if(!$result){
                $result=$result_json;
            }
        } catch (GuzzleException $e) {
            $result_json = $e->getResponse()->getBody()->getContents();
            print_r($result_json);
            $result = json_decode($result_json);  

        }
        return $result; 
        
    }


    public function call_delhivery3($api,$parameter = []){
        $client = new Client();
        $result=null;
        try {
            $param =  [
                
                'headers'=>[
                    'Authorization'=> "Token ".$this->settings['delhivery_key'],
                ],
                'verify' => false,
            ];
            $param['form_params']=$parameter;
            $response = $client->request('GET', 'https://track.delhivery.com/api/v1/'.$api, $param);
            $result_json = $response->getBody()->getContents();
            $result = json_decode($result_json);  
            if(!$result){
                $result=$result_json;
            }
        } catch (GuzzleException $e) {
            $result_json = $e->getResponse()->getBody()->getContents();
            print_r($result_json);
            $result = json_decode($result_json);  

        }
        return $result; 
        
    }
    public function call_delhivery2($api,$parameter = []){

        $client = new Client();
        $result=null;
        try {
            $param =  [
                
                'headers'=>[
                    'Authorization'=> "Token ".$this->settings['delhivery_key'],
                    'Content-type' => 'application/json'
                ],
                'verify' => false,
            ];
            $response = $client->request('GET', 'https://track.delhivery.com/api/kinko/v1/'.$api.'?'.http_build_query($parameter), $param);
            $result_json = $response->getBody()->getContents();
            $result = json_decode($result_json);  
            if(!$result){
                $result=$result_json;
            }
        } catch (GuzzleException $e) {
            $result_json = $e->getResponse()->getBody()->getContents();
            print_r($result_json);
            $result = json_decode($result_json);  

        }
        return $result; 
        
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
class ContentController extends ApiController
{

	public function get(){
		$result = DB::table('site_content')->get();
		$data = [];
		foreach ($result as $row) {
			$data[$row->name]=$row->value;
		}
		return response()->json(['status'=>1,'result'=>$data]);
	}
	public function upload(){
		$name = request()->input('name');
		$setting = DB::table('site_content')->where('name',$name)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/fabrics';
		$filename = $dir.'/'.md5($file['name'].time()).'.'.$ext;
		@mkdir('public/images');
		@mkdir('public/images/fabrics');
		if(move_uploaded_file($file['tmp_name'], $filename)){
			if($setting){
				if(file_exists($setting->value)){
					@unlink($setting->value);
				}
				// print_r($filename);
				DB::table('site_content')->where('name',$name)->update(['value'=>resizePicture($filename,$filename,600,true)]);
			}else{
				DB::table('site_content')->insert(['name'=>$name,'value'=>resizePicture($filename,$filename,600,true)]);
			}

		}
		return response()->json(['status'=>1,'msg'=>'Success']);
	}
	public function save_batch(){
		Cache::flush();
		$items = request()->input('items');
		$inclusive = request()->input('inclusive');
		foreach ($inclusive as $name) {
			if(!DB::table('site_content')->where('name',$name)->exists()){

				$id = DB::table('site_content')
					->insertGetId(['name'=>$name,
						'value'=>isset($items[$name])?$items[$name]:'']);
			}else{
				DB::table('site_content')
					->where('name',$name)
					->update(['name'=>$name,
						'value'=>isset($items[$name])?$items[$name]:'']);
			}
		}
		return response()->json(['status'=>1,'msg'=>'Success']);
	}
	public function save(){
		Cache::flush();
		$name=request()->input('name');
		$value=request()->input('value');
		

		$data = [
				'name'=>$name,
				'value'=>$value??'',	
				];
		if(!DB::table('site_content')->where('name',$name)->exists()){

			$id = DB::table('site_content')
				->insertGetId($data);
		}else{
			DB::table('site_content')
				->where('name',$name)
				->update($data);
		}

		return response()->json(['status'=>1,'msg'=>'Success']);
	}
}

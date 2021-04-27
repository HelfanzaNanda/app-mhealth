<?php

namespace App\Http\Controllers\Api\Admin\Content;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
class BannerController extends ApiController
{
	public function list(){

		$list = DB::table('banner')->orderBy('created_at','DESC')->get();
		$i=0;
		foreach ($list as &$row) {
			$i++;
			$row->no=$i;
		}
		return response()->json(['status'=>1,'result'=>$list]);
	}

	public function delete(){
		$id=request()->input('id');
		$image = DB::table('banner')->where('id',$id)->first();
		deleteImage($image->local);
		deleteImage($image->preview);
		DB::table('banner')->where('id',$id)->delete();
		return response()->json(['status'=>1]);
	}
	public function upload(){
		$link = request()->input('link');
		$type = request()->input('type');
		$link=!empty($link)?$link:'';
		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/banner';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;
		@mkdir('public/images');
		@mkdir('public/images/banner');
		if(move_uploaded_file($file['tmp_name'], $name)){
			// deleteImage($banner->image);
			// deleteImage($banner->preview);
			DB::table('banner')->insert([
				'image'=>($type=='mobile')?resizePicture($name,$name,600,true):resizePicture($name,$name,1350,true),
				'preview'=>($type=='mobile')?generate_preview($name,600):generate_preview($name,1350),
				'local'=>$name,
				'link'=>$link,
				'type'=>$type,
				'created_at'=>date("Y-m-d H:i:s")
			]);
			return response()->json(['status'=>1]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}

	public function save(){
		$id=request()->input('id');
		$link=request()->input('link');
		$type=request()->input('type');
		$link=!empty($link)?$link:'';
		$data = [
			'link'=>$link,
			'type'=>$type,
			];
		if(empty($id)){
			$id = DB::table('banner')
				->insertGetId($data);
		}else{
			DB::table('banner')
				->where('id',$id)
				->update($data);
		}
		return response()->json(['status'=>1,'msg'=>'Success']);
	}
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
class FileController extends ApiController
{
	public function list(){
		$userdata = $this->jwt_data['userdata'];
		$search = request()->input('search');
		$order = request()->input('order');
		$sort = request()->input('sort');
		$page = request()->input('page');
		$filter = request()->input('filter');
		$searchid = request()->input('searchid');
		$limit = 500;
		$offset = ($page-1)*$limit;
		$query=DB::table('auto_response')
			->where('auto_response.userid',$userid)
			->where(function($q)use($search){
				if($search!=''){
					$q->where('auto_response.keywords','like',"%$search%")
						->orWhere('auto_response.response','like',"%$search%");
				}
			})
			->where(function($q)use($filter){
				foreach ($filter as $key=>$value) {
					if(!empty($value)){
						$q->where('auto_response.'.$key,'like',"%$value%");
					}
				}		
			});

		$total = $query->count();
		$totalpage=ceil($total/$limit);
		$list = $query->orderBy($sort,$order)
			->limit($limit)
			->offset($offset)
			->get();

		$i=0;
		return response()->json(['status'=>1,'result'=>$list,'total'=>$total,'totalpage'=>$totalpage,'searchid'=>$searchid]);
	}

	public function get(){
		$id=request()->input('id');
		$result = (object)[
			'id'=>'',
			'keywords'=>'',
			'response'=>''
		];
		
		if(!empty($id)){
			$result = DB::table('auto_response')->where('id',$id)->first();
			$result->is_protected=false;
			
			if(!$result){
				return response()->json(['status'=>1,'msg'=>'Not found']);
			}
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function save(){
		Cache::flush();

		$userdata = $this->jwt_data['userdata'];
		$id=request()->input('id');
		$keywords=request()->input('keywords');
		$response=request()->input('response');

		$data = [
					'userid'=>$userdata->id,
					'keywords'=>json_encode($keywords),
					'response'=>$response,
					
				];
		if(empty($id)){
			$id = DB::table('auto_response')
				->insertGetId($data);
		}else{
			DB::table('auto_response')
				->where('id',$id)
				->update($data);
		}

		return response()->json(['status'=>1,'msg'=>'Success','id'=>$id]);
	}
	public function delete(){
		$id=request()->input('id');
		
		DB::table('auto_response')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}

	public function upload_image(){
		$id=request()->input('id');
		$category = DB::table('auto_response')->where('id',$id)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/category';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;

		
		@mkdir('public/images');
		@mkdir('public/images/category');
		@mkdir($dir);
		if(move_uploaded_file($file['tmp_name'], $name)){
			if(file_exists($category->image)){
				deleteImage($category->image);
			}
			DB::table('auto_response')->where('id',$id)->update([
				'image'=>resizePicture($name,$name,400,true),
			]);
			$image = DB::table('auto_response')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$image]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
}

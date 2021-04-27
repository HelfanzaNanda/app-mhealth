<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
use App\Models\User;
use DataTables;
class UserController extends ApiController
{
	
	public function save(){

		$userdata = $this->jwt_data['userdata'];
		$id=request()->input('id');
		$name=request()->input('name');
		$slug=request()->input('slug');
		$description=request()->input('description');
		$colorhex=request()->input('colorhex');
		$parentid=request()->input('parentid');
		$parentid=!empty($parentid)?$parentid:0;
		if(DB::table('category')->where('slug',$slug)->where('id','!=',$id)->exists()){	
			return response()->json(['status'=>0,'msg'=>"Category already exists"]);
		}
		// if($slug=='fabrics'){
		// 	return response()->json(['status'=>0,'msg'=>"Fabrics category are protected"]);
		// }
		$data = [
					'userid'=>$userdata->id,
					'name'=>$name,
					'slug'=>$slug,
					'description'=>$description,
					'colorhex'=>$colorhex,
					'parentid'=>$parentid,
					
				];
		if(empty($id)){
			$id = DB::table('category')
				->insertGetId($data);
		}else{
			DB::table('category')
				->where('id',$id)
				->update($data);
		}

		return response()->json(['status'=>1,'msg'=>'Success','id'=>$id]);
	}
	public function delete(){
		$id=request()->input('id');
		$query = DB::table('user_category')->where('categoryid',$id);
		$category = DB::table('category')->where('id',$id)->first();

		
		DB::table('category')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}
	public function migrate_category(){
		$from=request()->input('from');
		$to=request()->input('to');
		DB::table('user_category')->where('categoryid',$from)->update(['categoryid'=>$to]);		

	}

}

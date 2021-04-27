<?php

namespace App\Http\Controllers\Api\Admin\Master;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
class PaymentMethodController extends ApiController
{
	public function list(){
		$search = request()->input('search');
		$limit = request()->input('limit');
		$page = request()->input('page');
		$order = request()->input('order');
		$sort = request()->input('sort');
		$offset = $limit*($page-1);

		$query=DB::table('payment_method')
			->where(function($q)use($search){
				if($search!=''){
					$q->where('name','like',"%$search%");
				}
			});
		$total = $query->count();
		$totalpage=ceil($total/$limit);
		$list = $query->orderBy($order,$sort)
			->limit($limit)
			->offset($offset)
			->get();

		return response()->json(['status'=>1,'result'=>$list,'total'=>$total,'totalpage'=>$totalpage]);
	}
	public function get(){
		$id=request()->input('id');
		$result = DB::table('payment_method')->where('id',$id)->first();
		if(!$result){
			return response()->json(['status'=>1,'msg'=>'Not found']);
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function save(){
		$id=request()->input('id');
		$name=request()->input('name');

		$data = [
					'name'=>$name,
				];
		if(empty($id)){
			DB::table('payment_method')
				->insert($data);
		}else{
			DB::table('payment_method')
				->where('id',$id)
				->update($data);
		}

		return response()->json(['status'=>1,'msg'=>'Success']);
	}
	public function delete(){
		$id=request()->input('id');
		DB::table('payment_method')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
class AutoResponseController extends ApiController
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
			->where('auto_response.userid',$userdata->id)
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
		foreach ($list as &$row) {
			$row->keywords=json_decode($row->keywords)??[];
			// $row->keywords=implode(',',$row->keywords);
		}
		return response()->json(['status'=>1,'result'=>$list,'total'=>$total,'totalpage'=>$totalpage,'searchid'=>$searchid]);
	}

	public function get(){
		$id=request()->input('id');
		$result = (object)[
			'id'=>'',
			'keywords'=>[],
			'response'=>''
		];
		
		if(!empty($id)){
			$result = DB::table('auto_response')->where('id',$id)->first();
			$result->is_protected=false;
			
			if(!$result){
				return response()->json(['status'=>1,'msg'=>'Not found']);
			}
			$result->keywords=json_decode($result->keywords)??[];

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
					'keywords'=>json_encode(explode(',',$keywords)),
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

}

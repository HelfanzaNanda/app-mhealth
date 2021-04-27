<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
class ScheduleController extends ApiController
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
		$query=DB::table('schedule')
			->where('schedule.userid',$userdata->id)
			->where(function($q)use($search){
				if($search!=''){
					$q->where('schedule.name','like',"%$search%");
				}
			})
			->where(function($q)use($filter){
				foreach ($filter as $key=>$value) {
					if(!empty($value)){
						$q->where('schedule.'.$key,'like',"%$value%");
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
			'name'=>'',
			'body'=>'',
			'jangkawaktu'=>1,
			'type'=>'bydate',
			'msgtype'=>'single',
			'date'=>[],
			'message'=>[
				[
					'date'=>'',
					'body'=>'',
				]
			],
		];
		
		if(!empty($id)){
			$result = DB::table('schedule')->where('id',$id)->first();
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
		$name=request()->input('name');
		$message=request()->input('message');
		$date=request()->input('date');
		$tanggal=request()->input('tanggal');
		$jumlah=request()->input('jumlah');
		$hari=request()->input('hari');
		$data = [
					'userid'=>$userdata->id,
					'keywords'=>json_encode(explode(',',$keywords)),
					'response'=>$response,
					
				];
		if(empty($id)){
			$id = DB::table('schedule')
				->insertGetId($data);
		}else{
			DB::table('schedule')
				->where('id',$id)
				->update($data);
		}

		return response()->json(['status'=>1,'msg'=>'Success','id'=>$id]);
	}
	public function delete(){
		$id=request()->input('id');
		
		DB::table('schedule')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}

}

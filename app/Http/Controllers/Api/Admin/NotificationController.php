<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
class NotificationController extends ApiController
{
	public function list(){
		$search = request()->input('search');
		$limit = request()->input('limit');
		$page = request()->input('page');
		$order = request()->input('order');
		$sort = request()->input('sort');
		$offset = $limit*($page-1);

		$query=DB::table('notification')
			->select('notification.*')
			// ->leftJoin('contact','contact.id','notification.productid')
			->where(function($q)use($search){
				if($search!=''){
					$q->where('title','like',"%$search%")
						->orWhere('body','like',"%$search%");
				}
			});
		$total = $query->count();
		$totalpage=ceil($total/$limit);
		$list = $query->orderBy($sort,$order)
			->limit($limit)
			->offset($offset)
			->get();
		$i=0;
		foreach ($list as &$row) {
			$i++;
			$row->no=$offset+$i;
			$row->body=substr(strip_tags($row->body), 0,200);
			$row->created_at=date("d M, y H:i",strtotime($row->created_at));
		}
		return response()->json(['status'=>1,'result'=>$list,'total'=>$total,'totalpage'=>$totalpage]);
	}
	public function queue_list(){
		$search = request()->input('search');
		$limit = request()->input('limit');
		$page = request()->input('page');
		$order = request()->input('order');
		$sort = request()->input('sort');
		$offset = $limit*($page-1);

		$query=DB::table('notification_queue')
			->select('notification.*','notification_queue.*',
				DB::raw("(SELECT COUNT(*) FROM notification_queue_item WHERE notification_queue_item.queueid=notification_queue.id) as total"),
				DB::raw("(SELECT COUNT(*) FROM notification_queue_item WHERE notification_queue_item.push_status='sent' AND notification_queue_item.queueid=notification_queue.id) as done"))
			->join('notification','notification.id','notification_queue.notificationid')
			->where(function($q)use($search){
				if($search!=''){
					$q->where('title','like',"%$search%")
						->orWhere('body','like',"%$search%");
				}
			});
		$total = $query->count();
		$totalpage=ceil($total/$limit);
		$list = $query->orderBy($sort,$order)
			->limit($limit)
			->offset($offset)
			->get();
		$i=0;
		foreach ($list as &$row) {
			$i++;
			$row->no=$offset+$i;
			$row->body=substr(strip_tags($row->body), 0,200);
			$row->created_at=date("d M, y H:i",strtotime($row->created_at));
		}
		return response()->json(['status'=>1,'result'=>$list,'total'=>$total,'totalpage'=>$totalpage]);
	}
	public function send_notification(){
		$notificationid = request()->input('notificationid');
		$send_to=request()->input('send_to');
		$customeremails=request()->input('customeremails');
		$customer_list=[];
		$tmp = explode("\n", $customeremails);
		foreach ($tmp as $email) {
			if(!empty($email)){
				$customer_list[]=$email;
			}
		}

		if($send_to=='specific' && count($customer_list)==0 ){
			return response()->json(['status'=>0,'msg'=>"Empty Customer Ids"]);
		}
		$queueid = DB::table('notification_queue')->insertGetId([
			'notificationid'=>$notificationid,
			'send_to'=>$send_to,
			'status'=>'queued',
			'created_at'=>date("Y-m-d H:i:s")
		]);
		if($send_to=='all'){
			$customer_list = DB::table('contact')->pluck('email')->toArray();
		}
		if($send_to=='mailinglist'){
			$customer_list = DB::table('mail_list')->pluck('email')->toArray();
		}
		$customer_list = array_unique($customer_list);
		foreach ($customer_list as $email) {
			if($email!=''){
				DB::table('notification_queue_item')->insert([
					'email'=>$email,
					'queueid'=>$queueid,
					'notificationid'=>$notificationid,
					'status'=>'sent',
					'push_status'=>'pending'
				]);
			}
		}

		return response()->json(['status'=>1]);
		
	}
	public function get(){
		$id=request()->input('id');
		$result = (object)[
			'id'=>'',
			'name'=>'',
			'body'=>'',
			'type'=>'none',
			'product'=>[
				'id'=>0,
				'name'=>'',
			],
		];
		
		if(!empty($id)){
			$result = DB::table('notification')->where('id',$id)->first();
			// $product = DB::table('contact')
			// 			->select('contact.*')
			// 			->where('contact',$result->productid)->get();

			// $result->product=$product;
			if(!$result){
				return response()->json(['status'=>1,'msg'=>'Not found']);
			}
		}
		return response()->json(['status'=>1,'result'=>$result,]);
	}
	public function save_product(){
		$notificationid=request()->input('notificationid');
		$productid=request()->input('productid');
		DB::table('notification_product')->insert([
			'notificationid'=>$notificationid,
			'productid'=>$productid,
		]);
		return response()->json(['status'=>1,'msg'=>'Success']);

	}
	public function save(){
		$id=request()->input('id');
		$title=request()->input('title');
		$type=request()->input('type');
		$url=request()->input('url');
		$send_email=request()->input('send_email');
		$productid=request()->input('productid');

		$body=request()->input('body');
		$body=!empty($body)?$body:'';
		$productid=!empty($productid)?$productid:0;
		if(empty($title)){
			return response()->json(['status'=>0,'msg'=>'Title should not be empty']);

		}
		$data = [
				'title'=>$title,
				// 'send_email'=>$send_email,
				'body'=>$body,
				'type'=>'openurl',
				'image'=>'',
				// 'productid'=>$productid,
				// 'url'=>$url,
					
				];
		if(empty($id)){
			$data['created_at']=date("Y-m-d H:i:s");
			// $data['status']='draft';

			$id = DB::table('notification')
				->insertGetId($data);
		}else{
			DB::table('notification')
				->where('id',$id)
				->update($data);
		}
		return response()->json(['status'=>1,'msg'=>'Success','id'=>$id]);
	}
	public function upload_image(){
		$id=request()->input('id');
		$blog = DB::table('notification')->where('id',$id)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/blog';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;

		
		@mkdir('public/images');
		@mkdir('public/images/blog');
		@mkdir($dir);
		if(move_uploaded_file($file['tmp_name'], $name)){
			if(file_exists($blog->image)){
				deleteImage($blog->image);
			}
			DB::table('notification')->where('id',$id)->update([
				'image'=>$name,
			]);
			$image = DB::table('notification')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$image]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
	public function delete(){
		$id = request()->input('id');
		DB::table('notification')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}
	public function delete_queue(){
		$id = request()->input('id');
		DB::table('notification_queue')->where('id',$id)->delete();
		DB::table('notification_queue_item')->where('queueid',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}

	public function mention_product(){
		$notificationid=request()->input('notificationid');
		$productid=request()->input('productid');
		
		DB::table('notification')
			->where('notificationid',$notificationid)
			->update([
				'productid'=>$productid
			]);	
	
		
		return response()->json(['status'=>1]);
	}
	public function remove_mention_product(){
		$notificationid=request()->input('notificationid');
		$productid=request()->input('productid');
		
		DB::table('notification_product')->where([
			'notificationid'=>$notificationid,
			'productid'=>$productid
		])->delete();	
	
		return response()->json(['status'=>1]);
	}
}

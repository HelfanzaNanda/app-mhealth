<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use DB;
use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use Cache;
class CategoryController extends ApiController
{
	public function list(){
		$search = request()->input('search');
		$parentid = request()->input('parentid');
		$query=DB::table('category')
			// ->where('parentid',$parentid)
			->select('category.*','p.name as parent','p.slug as parent_slug')
			->leftJoin(DB::raw('category p'),'category.parentid','=','p.id')
			->where(function($q)use($search){
				if($search!=''){
					$q->where('name','like',"%$search%");
				}
			});

		$list = $query->orderBy('p.name','ASC')
			->get();

		$i=0;
		foreach ($list as &$row) {
			$i++;
			$row->no=$i;
			if(!empty($row->parent_slug)){
				$row->link=$this->settings['url'].'/'.$row->parent_slug.'/'.$row->slug;
			}else{
				$row->link=$this->settings['url'].'/'.$row->slug;
			}
		}
		return response()->json(['status'=>1,'result'=>$list]);
	}

	public function toogle_show_on_home(){
		$id=request()->input('id');
		$category = DB::table('category')->where('id',$id)->first();
		DB::table('category')->where('id',$id)->update([
			'show_on_home'=>(!$category->show_on_home)
		]);
		return response()->json(['status'=>0,'result'=>(!$category->show_on_home)]);

	}
	public function get(){
		$id=request()->input('id');
		$result = (object)[
			'id'=>'',
			'name'=>'',
			'slug'=>''
		];
		
		if(!empty($id)){
			$result = DB::table('category')->where('id',$id)->first();
			$result->is_protected=false;
			// if(in_array($result->slug, ['fabrics','men','acesories','women'])){
				// $result->is_protected=true;
			// }
			if(!$result){
				return response()->json(['status'=>1,'msg'=>'Not found']);
			}
		}
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function save(){
		Cache::flush();
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
		$query = DB::table('contact_category')->where('categoryid',$id);
		$category = DB::table('category')->where('id',$id)->first();

		// if($category->slug=='fabrics'){
		// 	return response()->json(['status'=>0,'msg'=>"Fabrics category are protected"]);
		// }
		// if($query->exists()){
		// 	return response()->json(['status'=>0,'msg'=>"Could not delete category, {$query->count()} Product(s) is using this category, move it first"]);
		// }

		DB::table('category')->where('id',$id)->delete();
		return response()->json(['status'=>1,'msg'=>'Deleted']);
	}
	public function migrate_category(){
		$from=request()->input('from');
		$to=request()->input('to');
		DB::table('contact_category')->where('categoryid',$from)->update(['categoryid'=>$to]);		

	}

	public function upload_image(){
		$id=request()->input('id');
		$category = DB::table('category')->where('id',$id)->first();

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
			DB::table('category')->where('id',$id)->update([
				'image'=>resizePicture($name,$name,400,true),
			]);
			$image = DB::table('category')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$image]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
	public function upload_logo(){
		$id=request()->input('id');
		$category = DB::table('category')->where('id',$id)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/category';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;

		
		@mkdir('public/images');
		@mkdir('public/images/category');
		@mkdir($dir);
		if(move_uploaded_file($file['tmp_name'], $name)){
			if(file_exists($category->logo)){
				deleteImage($category->logo);
			}
			DB::table('category')->where('id',$id)->update([
				'logo'=>$name,
			]);
			$logo = DB::table('category')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$logo]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
	public function upload_banner(){
		$id=request()->input('id');
		$category = DB::table('category')->where('id',$id)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/category';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;

		
		@mkdir('public/images');
		@mkdir('public/images/category');
		@mkdir($dir);
		if(move_uploaded_file($file['tmp_name'], $name)){
			if(file_exists($category->banner)){
				deleteImage($category->banner);
			}
			DB::table('category')->where('id',$id)->update([
				'banner'=>resizePicture($name,$name,1350,true),

			]);
			$image = DB::table('category')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$image]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
	public function upload_banner_mobile(){
		$id=request()->input('id');
		$category = DB::table('category')->where('id',$id)->first();

		$file = $_FILES['file'];
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$dir = 'public/images/category';
		$name = $dir.'/'.md5($file['name'].time()).'.'.$ext;

		
		@mkdir('public/images');
		@mkdir('public/images/category');
		@mkdir($dir);
		if(move_uploaded_file($file['tmp_name'], $name)){
			if(file_exists($category->banner_mobile)){
				deleteImage($category->banner_mobile);
			}
			DB::table('category')->where('id',$id)->update([
				'banner_mobile'=>resizePicture($name,$name,1350,true),

			]);
			$image = DB::table('category')->where('id',$id)->first();
			return response()->json(['status'=>1,'result'=>$image]);

		}
		return response()->json(['status'=>0,'msg'=>'error']);

		// print_r($file);
	}
}

<?php

namespace App\Http\Controllers\BackOffice;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\BidanProfile;
use App\Http\Controllers\BackOfficeController;
class BidanProfileController extends BackOfficeController
{
	public function datatables(){

		$data = BidanProfile::all();
		$datatables = datatables($data)
			->addColumn('_buttons',function($row){
				$editurl = route('backoffice.bidan-profile.edit',$row->id);
				return "<a class=\"btn btn-xs btn-info\" href=\"{$editurl}\"><i class=\"fa fa-edit\"></i> Edit</a>";
			})
			->rawColumns(['_buttons']);

		return $datatables->toJson();
	}
	public function save(){
		$id = request()->input('id');
		$name = request()->input('name');
		$email = request()->input('email');
		$role = request()->input('role');
		$password = request()->input('password');

		$data = [
			'name'=>$name,
			'email'=>$email,
			'role'=>$role,
		];
		if(BidanProfile::where('email',$email)->where('id','!=',$id)->exists()){
			return response()->json(['status'=>0,'msg'=>'Email sudah digunakan']);
		}
		if(!empty($id)){
			if(!empty($password)){
				$data['password'] = md5($password);
			}
			
			BidanProfile::where(['id'=>$id])->update($data);
		}else{
			if(empty($password)){
				return response()->json(['status'=>0,'msg'=>'Periksa password']);
			}
			$data['password']=md5($password);

			BidanProfile::insert($data);
		}
		return response()->json(['status'=>1]);
	}

	public function index(){
		return view('backoffice.bidan-profile.list');
	}
	public function edit($id){
		$data = BidanProfile::firstWhere('id',$id);
		$data->password='';
		return view('backoffice.bidan-profile.form',['title'=>"Edit - {$data->name}",'data'=>$data]);
	}
	public function insert(){
		return view('backoffice.bidan-profile.form',['title'=>'Insert','data'=>[
			'id'=>'',
			'name'=>'',
			'email'=>'',
			'password'=>'',
			'role'=>'pasien'
		]]);
	}
}

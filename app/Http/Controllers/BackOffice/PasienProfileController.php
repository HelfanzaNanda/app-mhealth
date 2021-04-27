<?php

namespace App\Http\Controllers\BackOffice;
use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\PasienProfile;
use App\Http\Controllers\BackOfficeController;
class PasienProfileController extends BackOfficeController
{
	public function datatables(){

		$data = PasienProfile::all();
		$datatables = datatables($data)
			->addColumn('_buttons',function($row){
				$editurl = route('backoffice.pasien-profile.edit',$row->id);
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
		if(PasienProfile::where('email',$email)->where('id','!=',$id)->exists()){
			return response()->json(['status'=>0,'msg'=>'Email sudah digunakan']);
		}
		if(!empty($id)){
			if(!empty($password)){
				$data['password'] = md5($password);
			}
			
			PasienProfile::where(['id'=>$id])->update($data);
		}else{
			if(empty($password)){
				return response()->json(['status'=>0,'msg'=>'Periksa password']);
			}
			$data['password']=md5($password);

			PasienProfile::insert($data);
		}
		return response()->json(['status'=>1]);
	}

	public function index(){
		return view('backoffice.pasien-profile.list');
	}
	public function edit($id){
		$data = PasienProfile::firstWhere('id',$id);
		$data->password='';
		return view('backoffice.pasien-profile.form',['title'=>"Edit - {$data->name}",'data'=>$data]);
	}
	public function insert(){
		return view('backoffice.pasien-profile.form',['title'=>'Insert','data'=>[
			'id'=>'',
			'name'=>'',
			'email'=>'',
			'password'=>'',
			'role'=>'pasien'
		]]);
	}
}

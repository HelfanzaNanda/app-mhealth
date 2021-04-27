<?php

namespace App\Http\Controllers\BackOffice;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Http\Controllers\BackOfficeController;
use App\Models\PromosiKesehatan;

class PromosiKesehatanController extends BackOfficeController
{
	public function datatables()
	{

		$data = PromosiKesehatan::all();
		$datatables = datatables($data)
			->addColumn('recommended', function($row){
				$input = '<div class="form-check">';
				$input .= '<input type="checkbox" onchange="recommended(this, '.$row->id.')" class="checkbox" '.($row->recommended ? 'checked' : '').' id="checkbox-'.$row->id.'">';
				$input .= '</div>';
				return $input;
			})
			->addColumn('_buttons', function ($row) {
				$editurl = route('backoffice.promosi-kesehatan.edit', $row->id);
				$btn = '<a class="btn btn-xs btn-info" href="'.$editurl.'"><i class="fa fa-edit"></i> Edit</a>';
				$btn .= '<a class="btn btn-xs btn-danger" onclick="Delete(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</a>';
                return $btn;
			})
			->rawColumns(['_buttons'])
			->escapeColumns([]);

		return $datatables->toJson();
	}
	public function save()
	{
		$id = request()->input('id');
		
		PromosiKesehatan::updateOrCreate(['id' => $id], [
			'date' => request()->input('date'),
			'title' => request()->input('title'),
			'body' => request()->input('body')
		]);
		return response()->json(['status' => 1]);
	}

	public function index()
	{
		return view('backoffice.promosi-kesehatan.list');
	}
	public function edit($id)
	{
		$data = PromosiKesehatan::firstWhere('id', $id);
		return view('backoffice.promosi-kesehatan.form', ['title' => "Edit - {$data->title}", 'data' => $data]);
	}

	public function insert()
	{
		return view('backoffice.promosi-kesehatan.form', [
			'title' => 'Insert',
			'data' => [
				'id' => '',
				'date' => '',
				'title' => '',
				'body' => '',
			]
		]);
	}

	public function delete($id)
	{
		PromosiKesehatan::destroy($id);
		return response()->json(['status' => 1]);
	}

	public function recommended($id)
	{
		$promosi = PromosiKesehatan::whereId($id)->first();
		$promosi->update([
			'recommended' => $promosi->recommended ? false : true
		]);
		return response()->json(['status' => 1]);
	}
}

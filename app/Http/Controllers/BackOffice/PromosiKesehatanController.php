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
			->addColumn('_buttons', function ($row) {
				$editurl = route('backoffice.promosi-kesehatan.edit', $row->id);
				return "<a class=\"btn btn-xs btn-info\" href=\"{$editurl}\"><i class=\"fa fa-edit\"></i> Edit</a>";
			})
			->rawColumns(['_buttons']);

		return $datatables->toJson();
	}
	public function save()
	{
		$id = request()->input('id');
		$title = request()->input('title');
		$body = request()->input('body');

		$data = [
			'title' => $title,
			'body' => $body,
			'show_bidan' => 1,
			'show_pasien' => 1,
		];
		if (!empty($id)) {
			PromosiKesehatan::where(['id' => $id])->update($data);
		} else {
			PromosiKesehatan::insert($data);
		}
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
		return view('backoffice.promosi-kesehatan.form', ['title' => 'Insert', 'data' => [
			'title' => '',
			'body' => '',
		]]);
	}
}

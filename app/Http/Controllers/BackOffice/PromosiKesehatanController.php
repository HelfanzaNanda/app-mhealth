<?php

namespace App\Http\Controllers\BackOffice;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Http\Controllers\BackOfficeController;
use App\Models\Kategori;
use App\Models\PromosiKesehatan;
use App\Traits\UploadFileTrait;

class PromosiKesehatanController extends BackOfficeController
{
	use UploadFileTrait;
	public function datatables()
	{

		$data = PromosiKesehatan::all();
		$datatables = datatables($data)
			->addColumn('recommended', function ($row) {
				$input = '<div class="form-check">';
				$input .= '<input type="checkbox" onchange="recommended(this, ' . $row->id . ')" class="checkbox" ' . ($row->recommended ? 'checked' : '') . ' id="checkbox-' . $row->id . '">';
				$input .= '</div>';
				return $input;
			})
			->addColumn('preview-cover', function ($row) {
				$img = '<img src="' .  asset($row->cover) . '" style="width: 100px; height: auto;">';
				return $img;
			})
			->addColumn('_buttons', function ($row) {
				$editurl = route('backoffice.promosi-kesehatan.edit', $row->id);
				$btn = '<a class="btn btn-xs btn-info" href="' . $editurl . '"><i class="fa fa-edit"></i> Edit</a>';
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
		$promosiKesehatan = PromosiKesehatan::where('id', $id)->first();
		PromosiKesehatan::updateOrCreate(['id' => $id], [
			'date' => now(),
			'kategori_id' => request()->input('kategori_id'),
			'cover' => (request()->file('cover') != '') ? 'uploads/images/' . $this->uploadImage(request()->file('cover')) : $promosiKesehatan->cover,
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
		$categories = Kategori::all();
		return view('backoffice.promosi-kesehatan.form', [
			'title' => "Edit - {$data->title}",
			'data' => $data,
			'categories' => $categories,
		]);
	}

	public function insert()
	{
		$categories = Kategori::all();
		return view('backoffice.promosi-kesehatan.form', [
			'title' => 'Insert',
			'categories' => $categories,
			'data' => [
				'kategori_id' => '',
				'id' => '',
				'cover' => '',
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

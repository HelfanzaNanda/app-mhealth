<?php

namespace App\Http\Controllers\BackOffice;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\BidanProfile;
use App\Http\Controllers\BackOfficeController;
use App\Models\Faskes;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;

class FaskesController extends BackOfficeController
{
	public function datatables()
	{
		$data = Faskes::all();
		$datatables = datatables($data)
			->addColumn('kelurahan', function ($row) {
				return $row->kelurahan->kelurahanName;
			})
			->addColumn('kecamatan', function ($row) {
				return $row->kecamatan->kecamatanName;
			})
			->addColumn('kabupaten', function ($row) {
				return $row->kabupaten->kabupatenName;
			})
			->addColumn('_buttons', function ($row) {
				$editurl = route('backoffice.faskes.edit', $row->id);
				$btn = '<a class="btn btn-xs btn-info" href="' . $editurl . '"><i class="fa fa-edit"></i> Edit</a>';
				$btn .= '<a class="btn btn-xs btn-danger" onclick="Delete(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</a>';
				return $btn;
			})
			->rawColumns(['_buttons']);
		return $datatables->toJson();
	}

	public function index()
	{
		return view('backoffice.faskes.list');
	}

	public function insert()
	{
		return view('backoffice.faskes.form', ['title' => 'Insert Faskes', 'data' => [
			'id' => '',
			'nama' => '',
			'alamat' => '',
			'email' => '',
			'nohp' => '',
			'provinsi' => '',
			'kabupaten' => '',
			'kecamatan' => '',
			'kelurahan' => '',
		]]);
	}

	public function edit($id)
	{
		$data = Faskes::firstWhere('id', $id);
		return view('backoffice.faskes.form', ['title' => "Edit - {$data->nama}", 'data' => $data]);
	}

	public function getProvinsi()
	{
		$provinsi = Provinsi::all();
		return $provinsi->toJson();
	}

	public function getKabupaten($provinsiId)
	{
		$kabupaten = Kabupaten::where('provinsiId', $provinsiId)->get();
		return $kabupaten->toJson();
	}

	public function getKecamatan($kabupatenId)
	{
		$kecamatan = Kecamatan::where('kabupatenId', $kabupatenId)->get();
		return $kecamatan->toJson();
	}

	public function getKelurahan($kecamatanId)
	{
		$kelurahan = Kelurahan::where('kecamatanId', $kecamatanId)->get();
		return $kelurahan->toJson();
	}

	public function save()
	{
		$id = request()->input('id');
		if ($id != '') {
			$faskes = Faskes::where(['id' => $id])->first();
			$faskes->nama = request()->input('nama');
			$faskes->alamat = request()->input('alamat');
			$faskes->nohp = request()->input('no_hp');
			$faskes->email = request()->input('email');
			$faskes->kelurahanId = request()->input('kelurahan');
			$faskes->kecamatanId = request()->input('kecamatan');
			$faskes->kabupatenId = request()->input('kabupaten');
			$faskes->update();
		} else {
			$faskes = new Faskes();
			$faskes->nama = request()->input('nama');
			$faskes->alamat = request()->input('alamat');
			$faskes->nohp = request()->input('no_hp');
			$faskes->email = request()->input('email');
			$faskes->kelurahanId = request()->input('kelurahan');
			$faskes->kecamatanId = request()->input('kecamatan');
			$faskes->kabupatenId = request()->input('kabupaten');
			$faskes->save();
		}
		return response()->json(['status' => 1]);
	}

	public function delete($id)
	{
		Faskes::destroy($id);
		return response()->json(['status' => 1]);
	}
}

<?php

namespace App\Http\Controllers\BackOffice;

use Guzzle;
use Requset;
use Route;
use DB;
use App\Models\User;
use App\Http\Controllers\BackOfficeController;
use App\Models\Rujukan;
use App\Models\RujukanDokumen;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\Response;

class RujukanController extends BackOfficeController
{
	use UploadFileTrait;

	public function datatables()
	{
		$data = Rujukan::all();
		$datatables = datatables($data)
			->addColumn('bidan', function ($row) {
				return $row->bidan->fullname;
			})
			->addColumn('pasien', function ($row) {
				return $row->pasien->fullname;
			})
			->addColumn('faskes', function ($row) {
				return $row->faskes->nama;
			})
			->addColumn('download_surat_rujukan', function ($row) {
				$downloadUrl = route('backoffice.rujukan.download.surat-rujukan', $row->upload_surat);
				$btn = '<a class="btn btn-xs btn-success" href="' . $downloadUrl . '">Download</a>';
				return $btn;
			})
			->addColumn('_buttons', function ($row) {
				$detailurl = route('backoffice.rujukan.detail', $row->id);
				$btn = '<a class="btn btn-xs btn-info" href="' . $detailurl . '"><i class="fa fa-eye"></i> Detail</a>';
				return $btn;
			})
			->rawColumns(['_buttons'])
			->escapeColumns([]);

		return $datatables->toJson();
	}

	public function save()
	{
		$rujukanId = request()->input('id');
		$files = request()->file('tindakan');
		// dd(request()->file('tindakan'));

		foreach ($files as $file) {
			$rujukanDokumen = new RujukanDokumen();
			$rujukanDokumen->rujukanid = $rujukanId;
			$rujukanDokumen->filename = $this->uploadImage($file);
			$rujukanDokumen->save();
		}

		return response()->json(['status' => 1]);
	}

	public function index()
	{
		return view('backoffice.rujukan.list');
	}
	public function detail($id)
	{
		$rujukan = Rujukan::where('id', $id)->first();
		return view('backoffice.rujukan.form', [
			'title' => 'Detail Rujukan: ' . $rujukan->pasien->fullname . ' -> ' . $rujukan->faskes->nama,
			'rujukan' => $rujukan,
		]);
	}

	public function download($filename)
	{
		$file = public_path() . "/uploads/images/" . $filename;
		$headers = array('Content-Type: application/pdf',);
		return Response::download($file, $filename, $headers);
	}
}

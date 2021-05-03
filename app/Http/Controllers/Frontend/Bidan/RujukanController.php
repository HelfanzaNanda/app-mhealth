<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\Faskes;
use App\Models\Rujukan;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class RujukanController extends HomeController
{
    use UploadFileTrait;

    public function index()
    {
        $moms = User::where('role', 'pasien')->get();
        $faskeses = Faskes::all();
        return view('frontend.bidan.rujukan.index', [
            'moms' => $moms,
            'faskeses' => $faskeses
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        unset($params['_token']);
        unset($params['file']);
        $params['upload_surat'] = $this->uploadImage($request->file('file'));
        $params['bidanid'] = $this->jwt_data['uid'];
        $params['status'] = true;
        $params['created_at'] = now();
        Rujukan::create($params);
        return response()->json(['status'=>1]);
    }
}

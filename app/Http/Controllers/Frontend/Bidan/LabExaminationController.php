<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Models\PemeriksaanLab;
use Illuminate\Http\Request;

class LabExaminationController extends HomeController
{
    public function index($pasien_id)
    {
        $userID = $this->jwt_data['uid'];
        $lab = PemeriksaanLab::where('bidanid', $userID)->where('pasienid', $pasien_id)->first();
        return view('frontend.bidan.pasien.modal.lab_examination.index', [
            'lab' => $lab,
            'pasien_id' => $pasien_id
        ]);
    }

    public function store(Request $request)
    {
        //return json_encode($request->all());
        $params = $request->all();
        $id = $request->id;
        unset($params['_token']);
        unset($params['id']);
        if ($id) {
            PemeriksaanLab::where('id', $id)->update($params);
        }else{
            $params['bidanid'] = $this->jwt_data['uid'];
            PemeriksaanLab::create($params);
        }
        return response()->json(['status'=>1]);
    }
}

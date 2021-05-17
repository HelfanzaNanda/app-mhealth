<?php

namespace App\Http\Controllers\Frontend\Bidan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanFisik;
use Illuminate\Http\Request;

class PhysicalExaminationController extends Controller
{
    public function index($pasien_id)
    {
        $userID = $this->jwt_data['uid'];
        $physic = PemeriksaanFisik::where('bidanid', $userID)->where('pasienid', $pasien_id)->first();
        return view('frontend.bidan.pasien.modal.physical-examination.index', [
            'physic' => $physic,
            'pasien_id' => $pasien_id
        ]);
    }

    public function store(Request $request)
    {
        //return json_encode($request->all());
        $params = $request->all();
        unset($params['_token']);
		$params['bidanid'] = $this->jwt_data['uid'];
        PemeriksaanFisik::create($params);
        return response()->json(['status' => 1]);
    }
}

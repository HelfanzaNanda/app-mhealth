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
        $id = $request->id;
        unset($params['_token']);
        unset($params['id']);
        if ($id) {
            PemeriksaanFisik::where('id', $id)->update($params);
        } else {
            $params['bidanid'] = $this->jwt_data['uid'];
            PemeriksaanFisik::create($params);
        }
        return response()->json(['status' => 1]);
    }
}

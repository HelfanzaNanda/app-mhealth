<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PasienRiwayatKesehatan;
use Illuminate\Http\Request;

class PasienRiwayatKesehatanController extends Controller
{
    public function getData()
    {
        $userid = $this->jwt_data['uid'];
        $data = PasienRiwayatKesehatan::where('pasienid', $userid)->get();
        return $data;
    }

    public function save()
    {
        $userid = $this->jwt_data['uid'];
        $keluhan = request()->input('keluhan') != "" ? request()->input('keluhan') : "-";
        $riwayat_penyakit = request()->input('riwayat_penyakit') != "" ? request()->input('riwayat_penyakit') : "-";
        $riwayat_penyakit_suami = request()->input('riwayat_penyakit_suami') != "" ? request()->input('riwayat_penyakit_suami') : "-";
        $riwayat_kdrt = request()->input('riwayat_kdrt') != "" ? request()->input('riwayat_kdrt') : "-";
        PasienRiwayatKesehatan::insert([
            'pasienid' => $userid,
            'keluhan' => $keluhan,
            'riwayat_penyakit' => $riwayat_penyakit,
            'riwayat_penyakit_suami' => $riwayat_penyakit_suami,
            'riwayat_kdrt' => $riwayat_kdrt,
        ]);
        return response()->json(['status' => 1]);
    }

    public function delete($id)
    {
        PasienRiwayatKesehatan::destroy($id);
        return response()->json(['status' => 1]);
    }
}

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
        $listKeluhan = request()->input('listKeluhan') != "" ? request()->input('listKeluhan') : "-";
        $listPenyakitAnda = request()->input('listPenyakitAnda') != "" ? request()->input('listPenyakitAnda') : "-";
        $listPenyakitSuami = request()->input('listPenyakitSuami') != "" ? request()->input('listPenyakitSuami') : "-";
        $listKDRT = request()->input('listKDRT') != "" ? request()->input('listKDRT') : "-";
        PasienRiwayatKesehatan::insert([
            'pasienid' => $userid,
            'keluhan' => (request()->has('listKeluhan')) ? implode(', ', $listKeluhan) : '-',
            'riwayat_penyakit' => (request()->has('listPenyakitAnda')) ? implode(', ', $listPenyakitAnda) : '-',
            'riwayat_penyakit_suami' => (request()->has('listPenyakitSuami')) ? implode(', ', $listPenyakitSuami) : '-',
            'riwayat_kdrt' => (request()->has('listKDRT')) ? implode(', ', $listKDRT) : '-',
        ]);
        return response()->json(['status' => 1]);
    }

    public function delete($id)
    {
        PasienRiwayatKesehatan::destroy($id);
        return response()->json(['status' => 1]);
    }
}

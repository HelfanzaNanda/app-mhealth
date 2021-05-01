<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ListPass;

class BidanTindakanController extends Controller
{
    public function save()
    {
        $bidanId = $this->jwt_data['uid'];
        $ibuHamilId = request()->input('ibuHamilId');
        $imunisasi = request()->input('imunisasi') == 'on' ? 1 : 0;
        $tablet = request()->input('tablet') == 'on' ? 1 : 0;
        $listObat = request()->input('listObat');

        Tindakan::create([
            'bidanid' => $bidanId,
            'pasienid' => $ibuHamilId,
            'date' => now(),
            'tablet_fe' => $tablet,
            'imunisasi' => $imunisasi,
            'obat' => implode(', ', $listObat)
        ]);

        return response()->json(['status' => 1]);
    }
}

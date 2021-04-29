<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PasienDiaryKehamilan;
use Illuminate\Http\Request;

class PasienDiaryKehamilanController extends Controller
{
    public function save()
    {
        $id = request()->input('id');
        $userID = $this->jwt_data['uid'];
        PasienDiaryKehamilan::updateOrCreate(['id' => $id], [
            'pasienid' => $userID,
            'created_at' => now(),
            'info1' => request()->input('info1'),
            'info2' => request()->input('info2'),
            'info3' => request()->input('info3'),
            'info4' => request()->input('info4'),
        ]);
        return response()->json(['status' => 1]);
    }
}

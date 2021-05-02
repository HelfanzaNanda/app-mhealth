<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{

    public function datatables()
    {
        $data = Notifikasi::all();
        $datatables = datatables($data)
            ->addColumn('fullname', function ($row) {
                return $row->user->fullname;
            })
            ->addColumn('_buttons', function ($row) {
                $btn = '<a class="btn btn-xs btn-danger" onclick="Delete(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</a>';
                return $btn;
            })
            ->rawColumns(['_buttons']);
        return $datatables->toJson();
    }

    public function index()
    {
        return view('backoffice.notifikasi.list');
    }

    public function insert()
    {
        $users = User::whereNotIn('role', ['admin'])->get();
        return view('backoffice.notifikasi.form', ['users' => $users]);
    }

    public function save()
    {
        $notifikasi = new Notifikasi();
        $notifikasi->userid = request()->input('userid');
        $notifikasi->subject = request()->input('subject');
        $notifikasi->body = request()->input('body');
        $notifikasi->status = 'pending';
        $notifikasi->created = now();
        $notifikasi->save();
        return response()->json(['status' => 1]);
    }

    public function delete($id)
    {
        Notifikasi::destroy($id);
        return response()->json(['status' => 1]);
    }
}

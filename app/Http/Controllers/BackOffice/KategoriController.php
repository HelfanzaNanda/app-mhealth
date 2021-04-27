<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class KategoriController extends Controller
{

    public function datatables()
    {
        $data = Kategori::all();
        $datatables = datatables($data)
            ->addColumn('_buttons', function ($row) {
                $editurl = route('backoffice.kategori.edit', $row->id);
                // $deleteurl = route('backoffice.kategori.delete', $row->id);
                $btn = '<a class="btn btn-xs btn-info" href="' . $editurl . '"><i class="fa fa-edit"></i> Edit</a>';
                $btn .= '<a class="btn btn-xs btn-danger" onclick="Delete(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</a>';
                return $btn;
                // return "<a class=\"btn btn-xs btn-info\" href=\"{$editurl}\"><i class=\"fa fa-edit\"></i> Edit</a>
                // <a class=\"btn btn-xs btn-danger\" href=\"#\" @click=\"Delete({$row->id})\"><i class=\"fa fa-trash\"></i> Delete</a>";
            })
            ->rawColumns(['_buttons']);

        return $datatables->toJson();
    }

    public function index()
    {
        return view('backoffice.kategori.list');
    }

    public function insert()
    {
        return view('backoffice.kategori.form', ['title' => 'Insert', 'data' => [
            'id' => '',
            'kategori' => '',
        ]]);
    }

    public function edit($id)
    {
        $data = Kategori::firstWhere('id', $id);
        return view('backoffice.kategori.form', ['title' => "Edit - {$data->kategori}", 'data' => $data]);
    }

    public function delete($id)
    {
        Kategori::destroy($id);
        return response()->json(['status' => 1]);
    }

    public function save()
    {
        $id = request()->input('id');
        $kategori = request()->input('kategori');

        $data = [
            'kategori' => $kategori,
        ];

        if (Kategori::where('kategori', $kategori)->where('id', '!=', $id)->exists()) {
            return response()->json(['status' => 0, 'msg' => 'Kategori sudah digunakan']);
        }

        if (!empty($id)) {
            $kategori = Kategori::where(['id' => $id])->update($data);
        } else {
            $kategori = Kategori::insert($data);
        }
        return response()->json(['status' => 1]);
    }
}

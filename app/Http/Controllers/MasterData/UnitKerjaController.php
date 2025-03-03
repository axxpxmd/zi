<?php

namespace App\Http\Controllers\MasterData;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\UnitKerja;

class UnitKerjaController extends Controller
{
    protected $route = 'unit-kerja.';
    protected $view  = 'pages.masterData.unitKerja.';
    protected $title = 'Unit Kerja';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    public function api(Request $request)
    {
        $tempats = UnitKerja::select("n_unit_kerja", "alamat", "id")->orderBy('id', 'DESC')->get();

        return DataTables::of($tempats)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' class='text-success' title='Edit'><i class='icon icon-edit mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger mr-2' title='Hapus'><i class='icon icon-remove'></i></a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'n_unit_kerja' => 'required|max:100'
        ]);

        // get params
        $n_unit_kerja = $request->n_unit_kerja;
        $alamat = $request->alamat;

        $tempat = new UnitKerja();
        $tempat->n_unit_kerja = $n_unit_kerja;
        $tempat->alamat = $alamat;
        $tempat->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $data = UnitKerja::where('id', $id)->first();

        return $data;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alamat' => 'required',
            'n_unit_kerja' => 'required|max:100'
        ]);

        // get params
        $n_unit_kerja = $request->n_unit_kerja;
        $alamat = $request->alamat;

        $tempat = UnitKerja::find($id);
        $tempat->update([
            'n_unit_kerja' => $n_unit_kerja,
            'alamat' => $alamat
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        UnitKerja::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}

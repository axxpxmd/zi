<?php

namespace App\Http\Controllers\Pengungkit;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\PengungkitIndikator1;

class PengungkitIndikator1Controller extends Controller
{
    protected $route = 'pengungkit-indikator-1.';
    protected $view  = 'pages.pengungkit.indikator1.';
    protected $title = 'Pengungkit Indikator 1';

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
        $tempats = PengungkitIndikator1::select("n_pengungkit_indikator1", "bobot", "id")->orderBy('id', 'DESC')->get();

        return DataTables::of($tempats)
            ->addColumn('action', function ($p) {
                // return "
                // <a href='#' onclick='edit(" . $p->id . ")' class='text-success' title='Edit'><i class='icon icon-edit mr-1'></i></a>
                // <a href='#' onclick='remove(" . $p->id . ")' class='text-danger mr-2' title='Hapus'><i class='icon icon-remove'></i></a>";
                return "-";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_pengungkit_indikator1' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_pengungkit_indikator1 = $request->n_pengungkit_indikator1;

        $tempat = new PengungkitIndikator1();
        $tempat->bobot = $bobot;
        $tempat->n_pengungkit_indikator1 = $n_pengungkit_indikator1;
        $tempat->bab_id = 1;
        $tempat->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $data = PengungkitIndikator1::where('id', $id)->first();

        return $data;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_pengungkit_indikator1' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_pengungkit_indikator1 = $request->n_pengungkit_indikator1;

        $tempat = PengungkitIndikator1::find($id);
        $tempat->update([
            'bobot' => $bobot,
            'n_pengungkit_indikator1' => $n_pengungkit_indikator1
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        PengungkitIndikator1::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}

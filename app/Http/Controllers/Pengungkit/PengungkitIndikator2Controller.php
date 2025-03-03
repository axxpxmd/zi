<?php

namespace App\Http\Controllers\Pengungkit;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\PengungkitIndikator1;
use App\Models\PengungkitIndikator2;

class PengungkitIndikator2Controller extends Controller
{
    protected $route = 'pengungkit-indikator-2.';
    protected $view  = 'pages.pengungkit.indikator2.';
    protected $title = 'Pengungkit Indikator 2';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $indikator1 = PengungkitIndikator1::select("n_pengungkit_indikator1", "id")->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'indikator1'
        ));
    }

    public function api(Request $request)
    {
        $indikator1_id = $request->indikator1_id;

        $datas = PengungkitIndikator2::select("n_pengungkit_indikator2", "bobot", "id")
            ->where('pengungkit_indikator1_id', $indikator1_id)
            ->get();

        return DataTables::of($datas)
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

        $data = new PengungkitIndikator2();
        $data->bobot = $bobot;
        $data->n_pengungkit_indikator1 = $n_pengungkit_indikator1;
        $data->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $data = PengungkitIndikator2::where('id', $id)->first();

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

        $data = PengungkitIndikator2::find($id);
        $data->update([
            'bobot' => $bobot,
            'n_pengungkit_indikator1' => $n_pengungkit_indikator1
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        PengungkitIndikator2::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Hasil;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\HasilIndikator;

class HasilIndikatorController extends Controller
{
    protected $route = 'hasil-indikator.';
    protected $view  = 'pages.hasil.indikator.';
    protected $title = 'Hasil Indikator';

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
        $datas = HasilIndikator::select("n_hasil_indikator", "bobot", "id")->orderBy('id', 'ASC')->get();

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
            'n_hasil_indikator' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_hasil_indikator = $request->n_hasil_indikator;

        $data = new HasilIndikator();
        $data->bobot = $bobot;
        $data->n_hasil_indikator = $n_hasil_indikator;
        $data->bab_id = 1;
        $data->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $data = HasilIndikator::where('id', $id)->first();

        return $data;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_hasil_indikator' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_hasil_indikator = $request->n_hasil_indikator;

        $data = HasilIndikator::find($id);
        $data->update([
            'bobot' => $bobot,
            'n_hasil_indikator' => $n_hasil_indikator
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        HasilIndikator::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}

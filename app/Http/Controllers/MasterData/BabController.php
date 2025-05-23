<?php

namespace App\Http\Controllers\MasterData;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\BAB;

class BabController extends Controller
{
    protected $route = 'bab.';
    protected $view  = 'pages.masterData.bab.';
    protected $title = 'BAB';

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
        $datas = BAB::select("n_bab", "bobot", "id")->orderBy('id', 'DESC')->get();

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
            'n_bab' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_bab = $request->n_bab;

        $data = new BAB();
        $data->bobot = $bobot;
        $data->n_bab = $n_bab;
        $data->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $data = BAB::where('id', $id)->first();

        return $data;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_bab' => 'required',
            'bobot' => 'required|max:100'
        ]);

        // get params
        $bobot = $request->bobot;
        $n_bab = $request->n_bab;

        $data = BAB::find($id);
        $data->update([
            'bobot' => $bobot,
            'n_bab' => $n_bab
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        BAB::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}

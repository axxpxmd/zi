<?php

namespace App\Http\Controllers\Pengungkit;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\PengungkitIndikator3;
use App\Models\PengungkitIndikator2;
use App\Models\PengungkitIndikator1;

class PengungkitIndikator3Controller extends Controller
{
    protected $route = 'pengungkit-indikator-3.';
    protected $view  = 'pages.pengungkit.indikator3.';
    protected $title = 'Pengungkit Indikator 3';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $indikator1 = PengungkitIndikator1::select("n_pengungkit_indikator1", "id")->get();
        $indikator2 = PengungkitIndikator2::select("n_pengungkit_indikator2", "id")->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'indikator2',
            'indikator1'
        ));
    }

    public function api(Request $request)
    {
        $pengungkit_indikator1_id = $request->pengungkit_indikator1_id;
        $pengungkit_indikator2_id = $request->pengungkit_indikator2_id;

        $datas = PengungkitIndikator3::select("tm_pengungkit_indikator3.n_pengungkit_indikator3", "tm_pengungkit_indikator3.bobot", "tm_pengungkit_indikator3.id", "tm_pengungkit_indikator3.pengungkit_indikator2_id")
            ->join('tm_pengungkit_indikator2', 'tm_pengungkit_indikator3.pengungkit_indikator2_id', '=', 'tm_pengungkit_indikator2.id')
            ->where('tm_pengungkit_indikator2.pengungkit_indikator1_id', $pengungkit_indikator1_id)
            ->when($pengungkit_indikator2_id != 0, function ($query) use ($pengungkit_indikator2_id) {
                return $query->where('tm_pengungkit_indikator3.pengungkit_indikator2_id', $pengungkit_indikator2_id);
            })
            ->orderBy('tm_pengungkit_indikator3.id', 'ASC')
            ->get();

        return DataTables::of($datas)
            ->addColumn('action', function ($p) {
                return "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger mr-2' title='Hapus'><i class='icon icon-remove'></i></a>";
            })
            ->editColumn('n_pengungkit_indikator3', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->n_pengungkit_indikator3 . "</a>";
            })
            ->addColumn('pengungkitPertanyaan', function ($p) {
                return $p->pengungkitPertanyaan->count() . "<a href='" . route('pengungkit-pertanyaan.create', ['pengungkit_indikator1_id' => $p->pengungkitIndikator2->pengungkit_indikator1_id, 'pengungkit_indikator2_id' => $p->pengungkit_indikator2_id, 'pengungkit_indikator3_id' => $p->id]) . "' class='text-success ml-2' title='Menambahkan pertanyaan'><i class='icon icon-add_circle mr-1'></i></a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'n_pengungkit_indikator3', 'pengungkitPertanyaan'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $route = $this->route;
        $title = $this->title;

        $pengungkit_indikator1_id = $request->pengungkit_indikator1_id;
        $pengungkit_indikator2_id = $request->pengungkit_indikator2_id;

        $indikator1 = PengungkitIndikator1::select("n_pengungkit_indikator1", "id")->where('id', $pengungkit_indikator1_id)->first();

        $indikators2 = PengungkitIndikator2::select("n_pengungkit_indikator2", "id", "bobot")->get();

        return view($this->view . 'create', compact(
            'route',
            'title',
            'pengungkit_indikator1_id',
            'pengungkit_indikator2_id',
            'indikator1',
            'indikators2'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_pengungkit_indikator3' => 'required|string|max:255|unique:tm_pengungkit_indikator3,n_pengungkit_indikator3',
            'bobot' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'pengungkit_indikator2_id' => 'required|exists:tm_pengungkit_indikator2,id',
        ]);

        PengungkitIndikator3::create([
            'n_pengungkit_indikator3' => $request->n_pengungkit_indikator3,
            'bobot' => $request->bobot,
            'pengungkit_indikator2_id' => $request->pengungkit_indikator2_id,
        ]);

        return redirect()->route($this->route . 'create', [
            'pengungkit_indikator1_id' => $request->pengungkit_indikator1_id,
            'pengungkit_indikator2_id' => $request->pengungkit_indikator2_id,
        ])->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $data = PengungkitIndikator3::find($id);

        return view($this->view . 'show', compact(
            'route',
            'title',
            'data'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_pengungkit_indikator3' => 'required|string|max:255|unique:tm_pengungkit_indikator3,n_pengungkit_indikator3,' . $id,
            'bobot' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        PengungkitIndikator3::find($id)->update([
            'n_pengungkit_indikator3' => $request->n_pengungkit_indikator3,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route($this->route . 'show', $id)->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        PengungkitIndikator3::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers\Pengungkit;

// Laravel Facades
use Yajra\DataTables\Facades\DataTables;

// Laravel Requests
use Illuminate\Http\Request;

// Base Controller
use App\Http\Controllers\Controller;

// Models
use App\Models\PengungkitIndikator3;
use App\Models\PengungkitPertanyaan;

class PengungkitPertanyaanController extends Controller
{
    protected $route = 'pengungkit-pertanyaan.';
    protected $view  = 'pages.pengungkit.pertanyaan.';
    protected $title = 'Pengungkit Pertanyaan';

    private $tipeJawabans = [
        "1" => "%",
        "2" => "A/B/C",
        "3" => "A/B/C/D",
        "4" => "A/B/C/D/E",
        "5" => "JUMLAH",
        "6" => "NILAI (0-4)",
        "7" => "YA/TIDAK",
    ];

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $indikator3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3")->get();

        return view($this->view . 'index', compact('route', 'title', 'indikator3'));
    }

    public function api(Request $request)
    {
        $pengungkit_indikator3_id = $request->pengungkit_indikator3_id;

        $datas = PengungkitPertanyaan::select("n_pertanyaan", "id", "pengungkit_indikator3_id", "tipe_jawaban")
            ->when($pengungkit_indikator3_id, function ($query) use ($pengungkit_indikator3_id) {
                return $query->where('pengungkit_indikator3_id', $pengungkit_indikator3_id);
            })
            ->get();

        return DataTables::of($datas)
            ->addColumn('action', function ($p) {
                return "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger mr-2' title='Hapus'><i class='icon icon-remove'></i></a>";
            })
            ->editColumn('tipe_jawaban', function ($p) {
                return $this->tipeJawabans[$p->tipe_jawaban];
            })
            ->editColumn('n_pertanyaan', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->n_pertanyaan . "</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'n_pertanyaan'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $route = $this->route;
        $title = $this->title;

        $indikators3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3", "bobot")->get();
        $indikator3  = PengungkitIndikator3::find($request->pengungkit_indikator3_id);

        $tipe_jawabans = $this->tipeJawabans;
        $pengungkit_indikator1_id = $request->pengungkit_indikator1_id;
        $pengungkit_indikator2_id = $request->pengungkit_indikator2_id;
        $pengungkit_indikator3_id = $request->pengungkit_indikator3_id;

        return view($this->view . 'create', compact(
            'route',
            'title',
            'indikator3',
            'indikators3',
            'tipe_jawabans',
            'pengungkit_indikator1_id',
            'pengungkit_indikator2_id',
            'pengungkit_indikator3_id',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'n_pertanyaan' => 'required|string|max:255|unique:tm_pengungkit_pertanyaan,n_pertanyaan',
            'tipe_jawaban' => 'required|integer|between:1,7',
            'pengungkit_indikator3_id' => 'required|exists:tm_pengungkit_indikator3,id',
            'keterangan' => 'nullable|string',
        ]);

        PengungkitPertanyaan::create($request->only(
            'n_pertanyaan',
            'tipe_jawaban',
            'pengungkit_indikator3_id',
            'keterangan'
        ));

        return redirect()->route($this->route . 'create', $request->only('pengungkit_indikator1_id', 'pengungkit_indikator2_id', 'pengungkit_indikator3_id'))
            ->with('success', 'Data berhasil disimpan');
    }

    public function getTotalPertanyaanByIndikator3($pengungkit_indikator3_id)
    {
        $total = PengungkitPertanyaan::where('pengungkit_indikator3_id', $pengungkit_indikator3_id)->count();

        return response()->json(['total' => $total]);
    }

    public function show(PengungkitPertanyaan $pengungkitPertanyaan)
    {
        $route = $this->route;
        $title = $this->title;

        $indikators3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3", "bobot")->get();

        $tipe_jawabans = $this->tipeJawabans;

        return view($this->view . 'show', compact(
            'route',
            'title',
            'pengungkitPertanyaan',
            'indikators3',
            'tipe_jawabans'
        ));
    }

    public function update(Request $request, PengungkitPertanyaan $pengungkitPertanyaan)
    {
        $request->validate([
            'n_pertanyaan' => 'required|string|max:255|unique:tm_pengungkit_pertanyaan,n_pertanyaan,' . $pengungkitPertanyaan->id,
            'tipe_jawaban' => 'required|integer|between:1,7',
            'pengungkit_indikator3_id' => 'required|exists:tm_pengungkit_indikator3,id',
            'keterangan' => 'nullable|string',
        ]);

        $pengungkitPertanyaan->update($request->only(
            'n_pertanyaan',
            'tipe_jawaban',
            'pengungkit_indikator3_id',
            'keterangan'
        ));

        return redirect()->route($this->route . 'show', $pengungkitPertanyaan->id)->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id){
        PengungkitPertanyaan::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}

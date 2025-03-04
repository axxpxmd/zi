<?php

namespace App\Http\Controllers\Pengungkit;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\PengungkitIndikator3;
use App\Models\PengungkitPertanyaan;

class PengungkitPertanyaanController extends Controller
{
    protected $route = 'pengungkit-pertanyaan.';
    protected $view  = 'pages.pengungkit.pertanyaan.';
    protected $title = 'Pengungkit Pertanyaan';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $indikator3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3")->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'indikator3'
        ));
    }

    public function api(Request $request)
    {
        $pengungkit_indikator3_id = $request->pengungkit_indikator3_id;

        $datas = PengungkitPertanyaan::select("n_pertanyaan", "id", "pengungkit_indikator3_id", "tipe_jawaban")
            ->when($pengungkit_indikator3_id, function ($query, $pengungkit_indikator3_id) {
                return $query->where('pengungkit_indikator3_id', $pengungkit_indikator3_id);
            })
            ->get();

        return DataTables::of($datas)
            ->addColumn('action', function ($p) {
                // return "
                // <a href='#' onclick='edit(" . $p->id . ")' class='text-success' title='Edit'><i class='icon icon-edit mr-1'></i></a>
                // <a href='#' onclick='remove(" . $p->id . ")' class='text-danger mr-2' title='Hapus'><i class='icon icon-remove'></i></a>";
                return "-";
            })
            ->editColumn('tipe_jawaban', function ($p) {
                $tipe_jawabans = [
                    "1" => "%",
                    "2" => "A/B/C",
                    "3" => "A/B/C/D",
                    "4" => "A/B/C/D/E",
                    "5" => "JUMLAH",
                    "6" => "NILAI (0-4)",
                    "7" => "YA/TIDAK",
                ];

                return $tipe_jawabans[$p->tipe_jawaban];
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

        $pengungkit_indikator1_id = $request->pengungkit_indikator1_id;
        $pengungkit_indikator2_id = $request->pengungkit_indikator2_id;
        $pengungkit_indikator3_id = $request->pengungkit_indikator3_id;

        $indikators3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3", "bobot")->get();

        $indikator3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3", "pengungkit_indikator2_id")->where("id", $pengungkit_indikator3_id)->first();

        $tipe_jawabans = [
            "1" => "%",
            "2" => "A/B/C",
            "3" => "A/B/C/D",
            "4" => "A/B/C/D/E",
            "5" => "JUMLAH",
            "6" => "NILAI (0-4)",
            "7" => "YA/TIDAK",
        ];

        return view($this->view . 'create', compact(
            'route',
            'title',
            'indikator3',
            'indikators3',
            'pengungkit_indikator1_id',
            'pengungkit_indikator2_id',
            'pengungkit_indikator3_id',
            'tipe_jawabans'
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

        PengungkitPertanyaan::create([
            'n_pertanyaan' => $request->n_pertanyaan,
            'tipe_jawaban' => $request->tipe_jawaban,
            'pengungkit_indikator3_id' => $request->pengungkit_indikator3_id,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route($this->route . 'create', [
            'pengungkit_indikator1_id' => $request->pengungkit_indikator1_id,
            'pengungkit_indikator2_id' => $request->pengungkit_indikator2_id,
            'pengungkit_indikator3_id' => $request->pengungkit_indikator3_id
        ])->with('success', 'Data berhasil disimpan');
    }

    public function getTotalPertanyaanByIndikator3($pengungkit_indikator3_id)
    {
        $total = PengungkitPertanyaan::where('pengungkit_indikator3_id', $pengungkit_indikator3_id)->count();

        return response()->json([
            'total' => $total
        ]);
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $data = PengungkitPertanyaan::findOrFail($id);
        $indikators3 = PengungkitIndikator3::select("id", "n_pengungkit_indikator3", "bobot")->get();

        $tipe_jawabans = [
            "1" => "%",
            "2" => "A/B/C",
            "3" => "A/B/C/D",
            "4" => "A/B/C/D/E",
            "5" => "JUMLAH",
            "6" => "NILAI (0-4)",
            "7" => "YA/TIDAK",
        ];

        return view($this->view . 'show', compact(
            'route',
            'title',
            'data',
            'indikators3',
            'tipe_jawabans'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'n_pertanyaan' => 'required|string|max:255|unique:tm_pengungkit_pertanyaan,n_pertanyaan,' . $id,
            'tipe_jawaban' => 'required|integer|between:1,7',
            'pengungkit_indikator3_id' => 'required|exists:tm_pengungkit_indikator3,id',
            'keterangan' => 'nullable|string',
        ]);

        PengungkitPertanyaan::findOrFail($id)->update([
            'n_pertanyaan' => $request->n_pertanyaan,
            'tipe_jawaban' => $request->tipe_jawaban,
            'pengungkit_indikator3_id' => $request->pengungkit_indikator3_id,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route($this->route . 'show', $id)->with('success', 'Data berhasil diupdate');
    }
}

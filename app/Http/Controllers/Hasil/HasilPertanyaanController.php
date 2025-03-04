<?php

namespace App\Http\Controllers\Hasil;

// Laravel Facades
use Yajra\DataTables\Facades\DataTables;

// Laravel Requests
use Illuminate\Http\Request;

// Base Controller
use App\Http\Controllers\Controller;
use App\Models\HasilIndikator;
use App\Models\HasilPertanyaan;
// Models
use App\Models\PengungkitIndikator3;
use App\Models\PengungkitPertanyaan;

class HasilPertanyaanController extends Controller
{
    protected $route = 'hasil-pertanyaan.';
    protected $view  = 'pages.hasil.pertanyaan.';
    protected $title = 'Hasil Pertanyaan';

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

        $indikators = HasilIndikator::select("id", "n_hasil_indikator")->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'indikators'
        ));
    }

    public function api(Request $request)
    {
        $hasil_indikator_id = $request->hasil_indikator_id;

        $datas = HasilPertanyaan::select("n_pertanyaan", "id", "hasil_indikator_id", "tipe_jawaban", "bobot")
            ->when($hasil_indikator_id, function ($query) use ($hasil_indikator_id) {
                return $query->where('hasil_indikator_id', $hasil_indikator_id);
            })
            ->get();

        return DataTables::of($datas)
            ->addColumn('action', function ($p) {
                return "-";
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

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $data = HasilPertanyaan::find($id);
        $indikators = HasilIndikator::select("id", "n_hasil_indikator", "bobot")->get();

        $tipe_jawabans = $this->tipeJawabans;

        return view($this->view . 'show', compact(
            'route',
            'title',
            'data',
            'indikators',
            'tipe_jawabans'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hasil_indikator_id' => 'required|exists:tm_hasil_indikator,id',
            'n_pertanyaan' => 'required|string|max:255|unique:tm_hasil_pertanyaan,n_pertanyaan,' . $id,
            'tipe_jawaban' => 'required|in:' . implode(',', array_keys($this->tipeJawabans)),
            'bobot' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $data = HasilPertanyaan::find($id);
        $data->update($request->all());

        return redirect()->route($this->route . 'show', $id)->with('success', 'Data berhasil diupdate');
    }
}

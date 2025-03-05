<?php

namespace App\Http\Controllers\Form;

// Laravel Facades
use Yajra\DataTables\Facades\DataTables;

// Laravel Requests
use Illuminate\Http\Request;

// Base Controller
use App\Http\Controllers\Controller;

// Models
use App\Models\Time;
use App\Models\Pegawai;

class FormPengisianController extends Controller
{
    protected $route = 'form-pengisian.';
    protected $view  = 'pages.form.pengisian.';
    protected $title = 'Form Pengisian';

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

        $tahuns = Time::select("id", "tahun")->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'tahuns'
        ));
    }

    public function api(Request $request)
    {
        $datas = Time::select("id", "tahun")->get();

        return DataTables::of($datas)
            ->addColumn('action', function ($p) {
                return "-";
            })
            ->editColumn('tahun', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->tahun . "</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tahun'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $request->validate([
            'tahun_id' => 'required|exists:tm_times,id',
        ]);

        $tahun_id = $request->tahun_id;

        $user_id  = auth()->user()->id;
        $data_opd = Pegawai::where('user_id', $user_id)->first();
        $waktu    = Time::find($tahun_id);

        return view($this->view . 'form', compact(
            'tahun_id',
            'waktu',
            'data_opd'
        ));
    }
}

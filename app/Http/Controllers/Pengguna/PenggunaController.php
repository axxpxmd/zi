<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Asip Hamdi
 * Github : axxpxmd
 */

namespace App\Http\Controllers\Pengguna;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

// Model
use App\User;
use App\Models\Time;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\ModelHasRole;
use App\Models\UserUnitKerja;
use Spatie\Permission\Models\Role;

class PenggunaController extends Controller
{
    protected $route = 'pengguna.';
    protected $view  = 'pages.pengguna.';
    protected $path  = 'images/ava/';
    protected $title = 'Pengguna';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $roles = Role::select('id', 'name')->get();
        $unit_kerja = UnitKerja::select('id', 'n_unit_kerja')->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'roles',
            'unit_kerja'
        ));
    }

    public function api(Request $request)
    {
        $role_id = $request->role_id;

        $pegawai = Pegawai::queryData($role_id);

        return DataTables::of($pegawai)
            ->addColumn('action', function ($p) {
                return "<a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Permission'><i class='icon icon-times'></i></a>";
            })
            ->editColumn('nama_instansi', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->nama_instansi . "</a>";
            })
            ->editColumn('unit_kerja', function ($p) {
                if ($p->unitKerja != null) {
                    return $p->unitKerja->n_unit_kerja;
                } else {
                    return '-';
                }
            })
            ->editColumn('username', function ($p) {
                return $p->user->username;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'role', 'nama', 'nama_instansi'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $route = $this->route;
        $title = $this->title;

        $role_id = $request->role_id;
        $unit_kerja_id = $request->unit_kerja_id;

        $role = Role::where('id', $role_id)->first();
        $unit_kerja = UnitKerja::where('id', $unit_kerja_id)->first();
        $unit_kerjas = UnitKerja::select('id', 'n_unit_kerja')->get();

        if ($role_id ==  null) {
            return redirect()
                ->route($this->route . 'index')
                ->withErrors('Semua form wajid diisi.');
        }

        return view($this->view . 'form_add', compact(
            'route',
            'title',
            'role',
            'role_id',
            'unit_kerja_id',
            'unit_kerja',
            'unit_kerjas'
        ));
    }

    public function store(Request $request)
    {
        if ($request->roleId == 5) {
            $request->validate([
                'username' => 'required|unique:tm_users,username',
                'email' => 'required|email|unique:tm_pegawais,email',
                'nama_instansi' => 'required',
                'nama_kepala' => 'required',
                'nama_operator' => 'required',
                'jabatan_operator' => 'required',
                'telp' => 'required|max:20',
                'alamat' => 'required|max:100',
                'unit_kerja_id' => 'required|unique:tm_pegawais,tempat_id'
            ], [
                'unit_kerja_id.unique' => 'Instansi ini telah memiliki login.',
            ]);
        }

        // Get Params
        $unit_kerja_id = $request->unit_kerja_id;
        $role_id = $request->role_id;
        $username = $request->username;
        $password = '12345678';
        $nama_instansi = $request->nama_instansi;
        $nama_kepala = $request->nama_kepala;
        $jabatan_kepala = $request->jabatan_kepala;
        $nama_operator = $request->nama_operator;
        $jabatan_operator = $request->jabatan_operator;
        $email = $request->email;
        $telp = $request->telp;
        $alamat = $request->alamat;
        $foto = 'default.png';
        $path = 'app\User';

        /* Tahapan :
         * 1. tm_users
         * 2. tm_pegawais
         * 3. model_has_roles
         */

        DB::transaction(function () use ($username, $password, $unit_kerja_id, $nama_instansi, $nama_kepala, $jabatan_kepala, $nama_operator, $jabatan_operator, $email, $telp, $alamat, $foto, $role_id, $path) {
            // Tahap 1: Create User
            $user = User::create([
                'username' => $username,
                'password' => Hash::make($password),
            ]);

            // Tahap 2: Create Pegawai
            Pegawai::create([
                'user_id' => $user->id,
                'unit_kerja_id' => $unit_kerja_id,
                'nama_instansi' => $nama_instansi,
                'nama_kepala' => $nama_kepala,
                'jabatan_kepala' => $jabatan_kepala,
                'nama_operator' => $nama_operator,
                'jabatan_operator' => $jabatan_operator,
                'email' => $email,
                'telp' => $telp,
                'alamat' => $alamat,
                'foto' => $foto,
            ]);

            // Tahap 3: Assign Role
            ModelHasRole::create([
                'role_id' => $role_id,
                'model_type' => $path,
                'model_id' => $user->id,
            ]);
        });

        return response()->json([
            'message' => "Data " . $this->title . " berhasil tersimpan."
        ]);
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;
        $path  = $this->path;

        $pegawai = Pegawai::find($id);
        $tahuns  = Time::select('id', 'tahun')->get();
        $verifikatorTempat = UserUnitKerja::where('user_id', $pegawai->user_id)->get();
        $verifikatorTempatArray = UserUnitKerja::select('unit_kerja_id')->where('user_id', $pegawai->user_id)->get()->toArray();

        $unit_kerjas = UnitKerja::select('id', 'n_unit_kerja')->get();

        return view($this->view . 'show', compact(
            'tahuns',
            'route',
            'title',
            'path',
            'pegawai',
            'verifikatorTempat',
            'unit_kerjas'
        ));
    }

    public function getPerangkatDaerah(Request $request)
    {
        $tahun_id = $request->tahun_id;
        $user_id = $request->user_id;

        $verifikatorTempat = UserUnitKerja::where('user_id', $user_id)
            ->where('tahun_id', $tahun_id)
            ->get();

        $dataJson = [];
        foreach ($verifikatorTempat as $key => $i) {
            $dataJson[$key] = [
                'unit_kerja' => $i->unitKerja->n_unit_kerja
            ];
        }

        return response()->json($dataJson);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);

        if ($pegawai->user->modelHasRole->role_id == 5) {
            $request->validate([
                'username'  => 'required|max:50|unique:tm_users,username,' . $pegawai->user_id,
                'email' => 'required|max:100|email|unique:tm_pegawais,email,' . $pegawai->id,
                'nama_instansi' => 'required',
                'nama_kepala' => 'required',
                'nama_operator' => 'required',
                'jabatan_operator' => 'required',
                'telp' => 'required|max:20',
                'alamat' => 'required|max:100',
            ]);
        }

        // Get Params
        $username = $request->username;
        $nama_instansi = $request->nama_instansi;
        $nama_kepala = $request->nama_kepala;
        $jabatan_kepala = $request->jabatan_kepala;
        $nama_operator = $request->nama_operator;
        $jabatan_operator = $request->jabatan_operator;
        $email = $request->email;
        $telp = $request->telp;
        $alamat = $request->alamat;

        /* Tahapan :
         * 1. tm_users
         * 2. tm_pegawais
         */

        // Tahap 1
        User::where('id', $pegawai->user_id)->update([
            'username' => $username
        ]);

        // Tahap 2
        $pegawai->update([
            'nama_instansi' => $nama_instansi,
            'nama_kepala' => $nama_kepala,
            'jabatan_kepala' => $jabatan_kepala,
            'nama_operator' => $nama_operator,
            'jabatan_operator' => $jabatan_operator,
            'email' => $email,
            'telp' => $telp,
            'alamat' => $alamat
        ]);

        // Tahap 4
        if ($request->opds) {
            foreach ($request->opds as $key => $i) {
                $check = UserUnitKerja::where('user_id', $pegawai->user_id)
                    ->where('tahun_id', $request->tahun_id)
                    ->where('unit_kerja_id', $i)
                    ->get();

                if ($check->count() > 0) {
                    return response()->json([
                        'message' => 'OPD ' . $check[0]->unitKerja->n_unit_kerja . ' telah terdaftar pada tahun ini.'
                    ], 422);
                } else {
                    UserUnitKerja::create([
                        'user_id' => $pegawai->user_id,
                        'unit_kerja_id' => $i,
                        'tahun_id' => $request->tahun_id
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function editPassword($id)
    {
        $route = $this->route;
        $title = $this->title;

        $user = User::find($id);

        return view($this->view . 'editPassword', compact(
            'route',
            'title',
            'user'
        ));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        user::where('id', $id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Pegawai::where('id', $id)->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function deleteVerifikatorTempat($id)
    {
        UserUnitKerja::where('id', $id)->delete();

        return back()
            ->withSuccess('berhasil terhapus.');
    }
}

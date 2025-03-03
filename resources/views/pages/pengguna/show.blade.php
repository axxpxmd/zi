@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4 class="ml-1">
                        <i class="icon icon-user-o mr-2"></i>
                        Show {{ $title }} | {{ $pegawai->nama_instansi }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li>
                        <a class="nav-link" href="{{ route($route.'index') }}"><i class="icon icon-arrow_back"></i>Semua Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active show" id="tab1" data-toggle="tab" href="#semua-data" role="tab"><i class="icon icon-user"></i>Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-toggle="tab" href="#tambah-data" role="tab"><i class="icon icon-edit"></i>Edit Data</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengguna.editPassword',$pegawai->user_id) }}" class="nav-link"><i class="icon icon-key4"></i>Ganti Password</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content my-3" id="pills-tabContent">
            @include('layouts.alert')
            <div class="tab-pane animated fadeInUpShort show active" id="semua-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h6 class="card-header"><strong>Data Login</strong></h6>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Username :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->user->username }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Role :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->user->modelHasRole->role->name }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <h6 class="card-header"><strong>Data Pengguna</strong></h6>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Nama Instansi:</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->nama_instansi }}</label>
                                    </div>
                                    @if ($pegawai->user->modelHasRole->role_id == 5)
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Nama Kepala :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->nama_kepala }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Jabatan Kepala :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->jabatan_kepala }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Nama Operator :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->nama_operator }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Jabatan Operator :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->jabatan_operator }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Email :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->email }}</label>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>No Telp :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->telp }}</label>
                                    </div>
                                    @if ($pegawai->user->modelHasRole->role_id == 5)
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Alamat :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pegawai->alamat }}</label>
                                    </div>
                                    @endif
                                    @if ($pegawai->user->modelHasRole->role_id == 6 && $verifikatorTempat)
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>OPD :</strong></label>
                                        <label class="col-md-1 text-right s-12">
                                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                @foreach ($tahuns as $key => $p)
                                                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="v-pills-home-tab" data-toggle="pill" href="#data{{ $key }}" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ $p->tahun }}</a>
                                                @endforeach
                                            </div>
                                        </label>
                                        <label class="col-md-9 s-12">
                                            <div class="tab-content" id="v-pills-tabContent">
                                                @foreach ($tahuns as $key => $p)
                                                @php
                                                    $tempats = App\Models\VerifikatorTempat::where('user_id', $pegawai->user_id)->where('tahun_id', $p->id)->get();
                                                @endphp
                                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="data{{ $key }}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                    @forelse ($tempats as $key1 => $h)
                                                    <li>
                                                        {{ $h->tempat->n_unit_kerja }}
                                                        <a href="{{ route('pengguna.deleteVerifikatorTempat', $h->id) }}" onclick="return confirm('Yakin ingin menghapus data ini?')"   class="text-danger"><i class="icon icon-times ml-2"></i></a>
                                                    </li>
                                                    @empty
                                                    <i>kosong</i>
                                                    @endforelse
                                                </div>
                                                @endforeach
                                            </div>
                                        </label>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Foto :</strong></label>
                                        @if ($pegawai->foto != null)
                                        <img class="ml-2 m-t-7 img-circular rounded-circle" src="{{ config('app.sftp_src') . $path . $pegawai->foto }}" width="100" height="100" alt="icon">
                                        @else
                                        <img class="ml-2 m-t-7 img-circular rounded-circle" src="{{ asset('images/boy.png') }}" width="100" height="100" alt="icon">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane animated fadeInUpShort show" id="tambah-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>
                        <div class="card">
                            <h6 class="card-header"><strong>Edit Data</strong></h6>
                            <div class="card-body">
                                <form class="needs-validation" id="form" method="PATCH"  enctype="multipart/form-data" novalidate>
                                    {{ method_field('PATCH') }}
                                    <input type="hidden" id="id" name="id" value="{{ $pegawai->id }}"/>
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $pegawai->user_id }}"/>
                                    <div class="form-row form-inline">
                                        <div class="col-md-8">
                                            <div class="form-group m-0">
                                                <label for="username" class="col-form-label s-12 col-md-2">Username</label>
                                                <input type="text" name="username" id="username" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->user->username }}" autocomplete="off" required/>
                                            </div>
                                            <hr>
                                            <div class="form-group m-0">
                                                <label for="nama_instansi" class="col-form-label s-12 col-md-2">Nama Instansi</label>
                                                <input type="text" name="nama_instansi" id="nama_instansi" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->nama_instansi }}" autocomplete="off" required/>
                                            </div>
                                            @if ($pegawai->user->modelHasRole->role_id == 5)
                                            <div class="form-group m-0">
                                                <label for="nama_kepala" class="col-form-label s-12 col-md-2">Nama Kepala</label>
                                                <input type="text" name="nama_kepala" id="nama_kepala" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->nama_kepala }}" autocomplete="off" required/>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="jabatan_kepala" class="col-form-label s-12 col-md-2">Jabatan Kepala</label>
                                                <input type="text" name="jabatan_kepala" id="jabatan_kepala" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->jabatan_kepala }}" autocomplete="off" required/>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="nama_operator" class="col-form-label s-12 col-md-2">Nama Operator</label>
                                                <input type="text" name="nama_operator" id="nama_operator" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->nama_operator }}" autocomplete="off" required/>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="jabatan_operator" class="col-form-label s-12 col-md-2">Jabatan Operator</label>
                                                <input type="text" name="jabatan_operator" id="jabatan_operator" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->jabatan_operator }}" autocomplete="off" required/>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="email" class="col-form-label s-12 col-md-2">Email</label>
                                                <input type="email" name="email" id="email" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->email }}" autocomplete="off" required/>
                                            </div>
                                            @endif
                                            <div class="form-group m-0">
                                                <label for="telp" class="col-form-label s-12 col-md-2">No Telp</label>
                                                <input type="text" name="telp" id="telp" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->telp }}" autocomplete="off" required/>
                                            </div>
                                            @if ($pegawai->user->modelHasRole->role_id == 5)
                                            <div class="form-group m-0">
                                                <label for="alamat" class="col-form-label s-12 col-md-2">Alamat</label>
                                                <input type="text" name="alamat" id="alamat" class="form-control r-0 light s-12 col-md-6" value="{{ $pegawai->alamat }}" autocomplete="off" required/>
                                            </div>
                                            @endif
                                            <hr>
                                            @if ($pegawai->user->modelHasRole->role_id == 6)
                                            <div class="form-group mb-1">
                                                <label class="col-form-label s-12 col-md-2">Tahun</label>
                                                <div class="col-md-6 p-0 bg-light">
                                                    <select name="tahun_id" id="tahun_id" onchange="getTempats()" class="select2 form-control r-0 light s-12">
                                                        @foreach($tahuns as $key=>$i)
                                                        <option value="{{ $i->id }}">{{ $i->tahun }}</option>
                                                        @endforeach
                                                    <select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-1">
                                                <label class="col-form-label s-12 col-md-2">Perangkat Daerah</label>
                                                <div class="col-md-6 p-0 bg-light">
                                                    <select name="opds[]" id="opds" placeholder="" class="select2 form-control r-0 light s-12" multiple="multiple">
                                                        @foreach($opds as $key=>$opds)
                                                        <option value="{{ $opds->id }}">{{ $opds->n_unit_kerja }}</option>
                                                        @endforeach
                                                    <select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group mt-2">
                                                <div class="col-md-2"></div>
                                                <button type="submit" class="btn btn-primary btn-sm" id="action"><i class="icon-save mr-2"></i>Simpan Perubahan<span id="txtAction"></span></button>
                                            </div>
                                        </div>
                                        @if ($pegawai->user->modelHasRole->role_id == 6)
                                        <div class="col-md-4">
                                            <strong>List OPD:</strong>
                                            <ol id="viewPermission" class=""></ol>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);
            url = "{{ route($route.'update', ':id') }}".replace(':id', $('#id').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData(($(this)[0])),
                contentType: false,
                processData: false,
                success : function(data) {
                    console.log(data);
                    $.confirm({
                        title: 'Success',
                        content: data.message,
                        icon: 'icon icon-check',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        autoClose: 'ok|3000',
                        type: 'green',
                        buttons: {
                            ok: {
                                text: "ok!",
                                btnClass: 'btn-primary',
                                keys: ['enter'],
                                action: function () {
                                    location.reload();
                                }
                            }
                        }
                    });
                },
                error : function(data){
                    err = '';
                    respon = data.responseJSON;
                    if(respon.errors){
                        $.each(respon.errors, function( index, value ) {
                            err = err + "<li>" + value +"</li>";
                        });
                    }
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('#action').removeAttr('disabled');
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
    });

    getTempats();
    function getTempats(){
        tahun_id = $('#tahun_id').val();
        user_id  = $('#user_id').val();

        $('#viewPermission').html("Loading...");
        url = "{{ route('pengguna.getPerangkatDaerah') }}?tahun_id=" + tahun_id + "&user_id=" + user_id;
        $.get(url, function(data){
            $('#viewPermission').html("");
            if(data.length > 0){
                $.each(data, function(index, value){
                    val = "'" + value.name + "'";
                    $('#viewPermission').append('<li>' + value.tempat + '</li>');
                });
            }else{
                $('#viewPermission').html("<em>Data OPD Kosong.</em>");
            }
        });
    }
</script>
@endsection

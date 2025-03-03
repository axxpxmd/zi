@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon icon-document-text mr-2"></i>
                        {{ $title }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li class="nav-item">
                        <a class="nav-link active show" id="tab1" data-toggle="tab" href="#semua-data" role="tab"><i class="icon icon-home2"></i>Semua Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-toggle="tab" href="#tambah-data" role="tab"><i class="icon icon-plus"></i>Tambah Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        @include('layouts.alert')
        <div class="tab-content my-3" id="pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="semua-data" role="tabpanel">
                <div class="card no-b mb-2">
                    <div class="card-body">
                        <div class="container col-md-12">
                            <div class="row mb-2">
                                <label for="pengungkit_indikator1_id_filter" class="col-form-label s-12 col-sm-4 col-md-4 col-xl-3 text-right font-weight-bolder">Indikator 1 </label>
                                <div class="col-md-4">
                                    <select name="pengungkit_indikator1_id_filter" id="pengungkit_indikator1_id_filter" class="select2 form-control r-0 light s-12">
                                        @foreach ($indikator1 as $i)
                                            <option value="{{ $i->id }}">{{ $i->n_pengungkit_indikator1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="pengungkit_indikator2_id_filter" class="col-form-label s-12 col-sm-4 col-md-4 col-xl-3 text-right font-weight-bolder">Indikator 2 </label>
                                <div class="col-md-4">
                                    <select name="pengungkit_indikator2_id_filter" id="pengungkit_indikator2_id_filter" class="select2 form-control r-0 light s-12">
                                        @foreach ($indikator2 as $i)
                                            <option value="{{ $i->id }}">{{ $i->n_pengungkit_indikator2 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-4 col-md-4 col-xl-3"></div>
                                <div class="col-sm-8 col-md-7 col-xl-6">
                                    <button class="btn btn-success btn-sm" onclick="pressOnChange()"><i class="icon-filter mr-2"></i>Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card no-b">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <th width="5%">No</th>
                                            <th width="75%">Nama</th>
                                            <th width="10%">Bobot</th>
                                            <th width="5%"></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane animated fadeInUpShort" id="tambah-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>
                        <div class="card">
                            <h6 class="card-header"><strong>Tambah Data</strong></h6>
                            <div class="card-body">
                                <form class="needs-validation" action="{{ route($route.'create') }}" method="GET"  novalidate>
                                    <div class="form-row form-inline">
                                        <div class="col-md-8">
                                            <div class="form-group mt-1">
                                                <label class="col-form-label s-12 col-md-2">Indikator 1</label>
                                                <div class="col-md-6 p-0 bg-light">
                                                    <select name="pengungkit_indikator1_id" id="pengungkit_indikator1_id" class="select2 form-control r-0 light s-12">
                                                        <option value="">Pilih</option>
                                                        @foreach ($indikator1 as $i)
                                                            <option value="{{ $i->id }}">{{ $i->n_pengungkit_indikator1 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mt-1">
                                                <label class="col-form-label s-12 col-md-2">Indikator 2</label>
                                                <div class="col-md-6 p-0 bg-light">
                                                    <select name="pengungkit_indikator2_id" id="pengungkit_indikator2_id" class="select2 form-control r-0 light s-12">
                                                        <option value="">Pilih</option>
                                                        @foreach ($indikator2 as $i)
                                                            <option value="{{ $i->id }}">{{ $i->n_pengungkit_indikator2 }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2">
                                                <div class="col-md-2"></div>
                                                <button type="submit" class="btn btn-primary btn-sm">Selanjutnya</button>
                                            </div>
                                        </div>
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
    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        order: [ 0, 'asc' ],
        pageLength: 15,
        ajax: {
            url: "{{ route($route.'api') }}",
            method: 'POST',
            data: function (data) {
                data.pengungkit_indikator2_id = $('#pengungkit_indikator2_id_filter').val();
                data.pengungkit_indikator1_id = $('#pengungkit_indikator1_id_filter').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'n_pengungkit_indikator3', name: 'n_pengungkit_indikator3'},
            {data: 'bobot', name: 'bobot', className: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    function remove(id){
        $.confirm({
            title: '',
            content: 'Apakah Anda yakin akan menghapus data ini?',
            icon: 'icon icon-question amber-text',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                ok: {
                    text: "ok!",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        $.post("{{ route($route.'destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
                            $('#dataTable').DataTable().ajax.reload();
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
                                        keys: ['enter']
                                    }
                                }
                            });
                        }, "JSON").fail(function(){
                            reload();
                        });
                    }
                },
                cancel: function(){}
            }
        });
    }

    function pressOnChange(){
        $('#dataTable').DataTable().ajax.reload();
    }
</script>
@endsection

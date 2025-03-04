@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4 class="ml-1">
                        <i class="icon icon-document-text mr-2"></i>
                        Edit {{ $title }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li class="nav-item">
                        <a class="nav-link active show" href="{{ route($route.'index') }}"><i class="icon icon-home2"></i>Semua Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content my-3" id="pills-tabContent">
            @include('layouts.alert')
            <div class="row">
                <div class="col-md-12">
                    <div id="alert"></div>
                    <div class="card">
                        <h6 class="card-header"><strong>Edit Data</strong></h6>
                        <div class="card-body">
                            <form action="{{ route($route.'update', $data->id) }}" class="needs-validation" method="POST"  enctype="multipart/form-data" novalidate>
                                {{ method_field('PATCH') }}
                                @csrf
                                <div class="form-row form-inline">
                                    <div class="col-md-12">
                                        <div class="form-group m-0">
                                            <label class="text-right s-12 col-md-2">Indikator</label>
                                            <input type="text" readonly class="form-control r-0 light s-12 col-md-4" autocomplete="off" value="{{ $data->hasilIndikator->n_hasil_indikator }}"/>
                                        </div>
                                        <hr>
                                        <div class="form-group m-0">
                                            <label class="col-form-label s-12 col-md-2">Indikator<span class="text-danger ml-1">*</span></label>
                                            <div class="col-md-4 p-0 bg-light">
                                                <select name="hasil_indikator_id" id="hasil_indikator_id" class="select2 form-control r-0 light s-12" required>
                                                    @foreach ($indikators as $i)
                                                        <option value="{{ $i->id }}" {{ $i->id == $data->hasil_indikator_id ? 'selected' : '' }}>{{ $i->n_hasil_indikator }} ( {{ $i->bobot }} )</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="n_pertanyaan" class="text-right s-12 col-md-2">Pertanyaan<span class="text-danger ml-1">*</span></label>
                                            <textarea type="text" name="n_pertanyaan" id="n_pertanyaan" rows="5" class="form-control r-0 light s-12 col-md-4" autocomplete="off" required>{{ $data->n_pertanyaan }}</textarea>
                                        </div>
                                        <div class="form-group m-0">
                                            <label class="col-form-label s-12 col-md-2">Tipe Jawaban<span class="text-danger ml-1">*</span></label>
                                            <div class="col-md-4 p-0 bg-light">
                                                <select name="tipe_jawaban" id="tipe_jawaban" class="select2 form-control r-0 light s-12" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($tipe_jawabans as $key => $i)
                                                        <option value="{{ $key }}" {{ $key == $data->tipe_jawaban ? 'selected' : '-' }}>{{ $i }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="bobot" class="text-right s-12 col-md-2">Bobot<span class="text-danger ml-1">*</span></label>
                                            <input type="number" name="bobot" id="bobot" value="{{ $data->bobot }}" class="form-control r-0 light s-12 col-md-4" autocomplete="off" required/>
                                        </div>
                                        <div class="table-responsive">
                                            <div class="form-group m-0">
                                                <label for="keterangan" class="text-right s-12 col-md-2">Keterangan<span class="text-danger ml-1">*</span></label>
                                                <textarea name="keterangan" class="form-control r-0 light s-12 col-md-10" id="tiny">{{ $data->keterangan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="bab" class="text-right s-12 col-md-2"></label>
                                            <button type="submit" class="btn btn-success btn-sm"><i class="icon-save mr-2"></i>Perbarui Data</button>
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
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.tiny.cloud/1/asaiytuil3ir60nu7aw6buvvgkzso2azpt3cgv2iss02fstk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
<script type="text/javascript">
    $('textarea#tiny').tinymce({
        height: 300,
        menubar: false,
        branding: false,
        placeholder: 'Ketikkan keterangan disini...',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic backcolor | ' +
        'alignleft aligncenter alignright alignjustify | lineheight |' +
        'bullist numlist outdent indent | removeformat | help'
    });
</script>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <link rel="icon" href="{{ asset('images/template/tangsel.png') }}" type="image/x-icon">
    <title>ZI | Form Pengisian</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Pilih";
        }
    </style>

</head>
<body>
    <div class="container-contact100 justify-content-center">
        <div class="container p-0">
            <div class="col-md-12 p-0">
                <div class="wrap-contact100 p-0">
                    <div class="text-center p-2">
                        <p class="fs-21 font-weight-bold text-black">ZONA INTEGRITAS</p>
                        <p class="fs-21 font-weight-bold text-black text-uppercase" style="margin-top: -15px !important">DI LINGKUNGAN UNIT KERJA</p>
                        <p class="fs-21 font-weight-bold text-black text-uppercase" style="margin-top: -15px !important">KOTA TANGERANG SELATAN</p>
                        <p class="fs-21 font-weight-bold text-black text-uppercase" style="margin-top: -15px !important">TAHUN {{ $waktu->tahun }}</p>
                    </div>
                    <hr width="1100px" style="margin-top: -20px">
                    <div class="container">
                        <div class="col-md-12 text-black font-weight-bold">
                            <div class="mb-2">
                                <a class="fs-13 text-danger" href="{{ route('form-pengisian.index') }}"><i class="icon icon-arrow-left mr-2"></i>Kembali</a>
                            </div>
                            <div class="row">
                                <label class="col-md-2"><strong>Nama Kepala</strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->nama_kepala }}</label>
                            </div>
                            <div class="row mt-n1">
                                <label class="col-md-2"><strong>Jabatan Kepala</strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->jabatan_kepala }}</label>
                            </div>
                            <div class="row">
                                <label class="col-md-2"><strong>Nama Operator</strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->nama_operator }}</label>
                            </div>
                            <div class="row">
                                <label class="col-md-2"><strong>Jabatan Operator</strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->jabatan_operator }}</label>
                            </div>
                            <div class="row">
                                <label class="col-md-2"><strong>Email</strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->email }}</label>
                            </div>
                            <div class="row mt-n1">
                                <label class="col-md-2"><strong>No Telp </strong></label>
                                <label class="col-md-10 pl-0">: {{ $data_opd->telp }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (now() < $waktu->start)
        <div class="container p-0 mt-1">
            <div class="col-md-12 p-0">
                <div class="wrap-contact100 p-0">
                    <div class="text-center container text-black p-2">
                        <img class="mb-4" src="{{ asset('images/hourglass.gif') }}" width="100" alt="">
                        <p class="text-danger">Waktu pengisian kuesioner belum dimulai. </p>
                        <p class="text-danger mt-n3">Mulai pada : <span class="font-weight-bold">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $waktu->start)->format('d M Y | h:i:s') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        @elseif(now() > $waktu->end)
        <div class="container p-0 mt-1">
            <div class="col-md-12 p-0">
                <div class="wrap-contact100 p-0">
                    <div class="container text-center text-black p-2">
                        <img class="mb-4" src="{{ asset('images/letter-x.gif') }}" width="100" alt="">
                        <p class="text-danger">Waktu pengisian kuesioner Sudah Berakhir. </p>
                        <p class="text-danger mt-n3">Berakhir pada : <span class="font-weight-bold">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $waktu->end)->format('d M Y | h:i:s') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <form action="#" method="POST" id="form" enctype="multipart/form-data">
            {{ method_field('POST') }}
            {{ csrf_field() }}
        </form>
        @endif
    </div>
</body>
    <!-- Script -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/myScript.js') }}"></script>
    <script>
		window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
	</script>
    <script src="{{ asset('assets1/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.1/js/fileinput.js"></script>

    <script>
        $('#form').on('submit', function (e) {
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            else{
                $('#submitButton').attr('disabled', true);
            }
        });

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $("#successAlert").fadeTo(5000, 1000).slideUp(1000, function() {
                $("#successAlert").slideUp(1000);
            });
        });

        $(document).ready(function() {
            $("#errorAlert").fadeTo(5000, 1000).slideUp(1000, function() {
                $("#errorAlert").slideUp(1000);
            });
        });
    </script>
</html>

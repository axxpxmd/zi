<ul class="sidebar-menu">
    <li class="header"><strong>MAIN NAVIGATION</strong></li>
    <li>
        <a href="{{ route('home') }}">
            <i class="icon icon-home red-text s-18"></i>
            <span>Home</span>
        </a>
    </li>
    @can('master-role')
    <li class="header light"><strong>ROLE</strong></li>
    <li class="no-b">
        <a href="{{ route('master-role.permission.index') }}">
            <i class="icon icon-clipboard-list text-red s-18"></i>
            <span>Permission</span>
        </a>
    </li>
    <li>
        <a href="{{ route('master-role.role.index') }}">
            <i class="icon icon-key3 amber-text s-18"></i>
            <span>Role</span>
        </a>
    </li>
    @endcan
    @can('master-pegawai')
    <li class="header light"><strong>PENGGUNA</strong></li>
    <li class="no-b">
        <a href="{{ route('pengguna.index') }}">
            <i class="icon icon-user-o text-success s-18"></i>
            <span>Pengguna</span>
        </a>
    </li>
    @endcan
    @can('master-data')
    <li class="header light"><strong>MASTER DATA</strong></li>
    <li class="no-b">
        <a href="{{ route('unit-kerja.index') }}">
            <i class="icon icon-building text-yellow s-18"></i>
            <span>Unit Kerja</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('waktu.index') }}">
            <i class="icon icon-timer text-primary s-18"></i>
            <span>Waktu</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('bab.index') }}">
            <i class="icon icon-document-text text-danger s-18"></i>
            <span>BAB</span>
        </a>
    </li>
    @endcan
    @can('data-pengungkit')
    <li class="header light"><strong>DATA PENGUNGKIT</strong></li>
    <li class="no-b">
        <a href="{{ route('pengungkit-indikator-1.index') }}">
            <i class="icon icon-document-text text-success s-18"></i>
            <span>Indikator 1</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('pengungkit-indikator-2.index') }}">
            <i class="icon icon-document-text text-primary s-18"></i>
            <span>Indikator 2</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('pengungkit-indikator-3.index') }}">
            <i class="icon icon-document-text text-warning s-18"></i>
            <span>Indikator 3</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('pengungkit-pertanyaan.index') }}">
            <i class="icon icon-document-text text-secondary s-18"></i>
            <span>Pertanyaan</span>
        </a>
    </li>
    @endcan
    @can('data-hasil')
    <li class="header light"><strong>DATA HASIL</strong></li>
    <li class="no-b">
        <a href="{{ route('hasil-indikator.index') }}">
            <i class="icon icon-document-text text-success s-18"></i>
            <span>Indikator</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('hasil-pertanyaan.index') }}">
            <i class="icon icon-document-text text-primary s-18"></i>
            <span>Pertanyaan</span>
        </a>
    </li>
    @endcan
    @can('form')
    <li class="header light"><strong>FORM</strong></li>
    <li class="no-b">
        <a href="{{ route('form-pengisian.index') }}">
            <i class="icon icon-document-text text-danger s-18"></i>
            <span>Pengisian</span>
        </a>
    </li>
    @endcan
</ul>

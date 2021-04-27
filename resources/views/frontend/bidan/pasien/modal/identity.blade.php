@extends('frontend.layouts.app')
@section('content')
<div class="container box-shadow">
    <div class="mx-1 shadow shadow-lg">
        <div class="d-flex justify-content-between align-items-center">
            <div class="py-3">
                <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
            </div>
            {{-- <div class="py-3">
                <a href="" class="text-gray">Edit</a>
            </div> --}}
        </div>
        
        <div class="row justify-content-center">
            <div class="text-header font-size-18 text-active-pink">Profil Pasien</div>
            <div class="row justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500">Profil Pasien</div>
            </div>
        </div>
    </div>
</div>
<div class="bg-grey py-4 " style="max-height: 86vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Nama</label>
                    <h6>Auristela Allisya</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Tempat, Tanggal Lahir</label>
                    <h6>Jakarta, 20 Mei 1996</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Agama</label>
                    <h6>Islam</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Alamat</label>
                    <h6>Jakarta Utara</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Situasi Keluarga</label>
                    <h6>Bersama Keluarga</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">No. Hp</label>
                    <h6>08123456789</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pendidikan Terakhir</label>
                    <h6>Magister Ilmu Komputer</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pekerjaan</label>
                    <h6>Kepala Dinas</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Suku</label>
                    <h6>-</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Data Keluarga</label>
                    <h6>-</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

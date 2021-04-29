@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Nama</label>
                    <h6>{{$user->fullname}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Tempat, Tanggal Lahir</label>
                    <h6>{{$data->tempatlahir}}, {{date("d M Y",strtotime($data->tanggallahir))}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Agama</label>
                    <h6>{{$data->agama}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Suku</label>
                    <h6>{{$data->suku}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Alamat</label>
                    <h6>{{$user->alamat}} <br/>
                        {{$user->kelurahan->kelurahanName??''}}, 
                        {{$user->kecamatan->kecamatanName??''}}, 
                        {{$user->kabupaten->kabupatenName??''}}, 
                        {{$user->provinsi->provinsiName??''}} </h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">No. Hp</label>
                    <h6>{{$user->nohp}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Situasi Keluarga</label>
                    <h6>{{$data->keluarga}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pendidikan Terakhir</label>
                    <h6>{{$data->pendidikan}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pekerjaan</label>
                    <h6>{{$data->pekerjaan}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

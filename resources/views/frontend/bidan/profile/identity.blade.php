@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">SIPB</label>
                    <h6>{{$user->sipb}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Nama</label>
                    <h6>{{$user->fullname}}</h6>
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
            </div>
        </div>
    </div>
</div>
@endsection

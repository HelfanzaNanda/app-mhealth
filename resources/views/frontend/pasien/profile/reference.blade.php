@extends('frontend.layouts.app')
@section('content')
<div class="container box-shadow bg-white">
    <div class="shadow shadow-lg">
        <div class="py-3">
            <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
        </div>
        <div class="row justify-content-center">
            <div class="text-header font-size-18 text-active-pink font-weight-500">Rujukan</div>
        </div>
    </div>
</div>
<div class="bg-grey pt-23 mt-n1" style="height: 86vh; overflow: auto">
    <div class="container-mhealth h-100">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Tanggal</label>
                    <h6>12 April 2021</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Nomor Surat</label>
                    <h6>118 622322</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Tujuan</label>
                    <h6>RS Ibu Ceria</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

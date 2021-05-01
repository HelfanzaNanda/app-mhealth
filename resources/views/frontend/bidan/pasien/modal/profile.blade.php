@extends('frontend.layouts.app')
@section('content')
<div class="pb-4" style="max-height: 93vh; overflow: auto">
    <div class="profile-card mb-3">
        <div class="container-mhealth">
            <div class="col-12 shadow shadow-lg">
                <div class="row justify-content-center">
                    <div class="text-header font-size-18 font-weight-500 text-white">Profil</div>
                </div>
            </div>
            <div class="row mt-62 mb-20">
                <div class="thumb-lg mx-auto">
                    <img src="{{ asset('images/profile.png') }}" alt="profile-image" width="120" height="120">
                </div>
            </div>
            <div class="text-white text-center mt-3 mb-29">
                <div class="font-size-24 font-weight-700">{{ $user->fullname }}</div>
                <div class="text-pink font-size-18">{{ $user->tanggallahir }}</div>
            </div>
            <div class="text-center">
                <button type="button"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Identitas
                    Pasien</button>
                <button type="button"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat Kehamilan
                    Sekarang</button>
                <button type="button"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat
                    Kontrasepsi</button>
                <button type="button"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat Kehamilan
                    Sebelumnya</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <a href="#" class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Pemeriksaan Fisik</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#" class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Pemeriksaan Lab</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#" class="d-flex justify-content-between mb-29"
                    onclick="openFrame('{{route('bidan.pasien.modal.action', $user->id)}}','Tindakan')">
                    <span class="font-size-16 text-black font-weight-500">Tindakan</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#" class="d-flex justify-content-between">
                    <span class="font-size-16 text-black font-weight-500">Rujukan</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
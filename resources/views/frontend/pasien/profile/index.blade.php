@extends('frontend.layouts.app')
@section('content')
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
                <div class="font-size-24 font-weight-700">{{$data->fullname}}</div>
                <div class="text-pink font-size-18">24 Tahun</div>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-block btn-profile bg-white text-active-pink font-weight-500" onclick="openIdentity()">Identitas Anda</button>
                <button type="button" class="btn btn-block btn-profile bg-white text-active-pink font-weight-500" onclick="openFrame()">Riwayat Kehamilan Sekarang</button>
                <button type="button" class="btn btn-block btn-profile bg-white text-active-pink font-weight-500" onclick="openFrame()">Riwayat Kontrasepsi</button>
                <button type="button" class="btn btn-block btn-profile bg-white text-active-pink font-weight-500" onclick="openFrame()">Riwayat Kehamilan Sebelumnya</button>
            </div>


        </div>
    </div>

    <div class="container" >
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
                <a href="#" class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Tindakan</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#" class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Rujukan</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
            </div>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        function openIdentity(){
            openFrame('{{route('pasien.profile.modal.identity')}}','Profil',{
                button:{
                    text:'Edit',
                    onclick:function(){
                        openFrame('{{route('pasien.profile.modal.edit')}}','Edit Profil')
                    }
                }
            })
        }
    </script>
    @endpush
@endsection

@extends('frontend.layouts.frame')
@section('content')
<div class="pb-4" style="max-height: 93vh; overflow: auto">
    <div class="profile-card mb-3">
        <div class="container-mhealth">
            <div class="col-12 shadow shadow-lg">
                {{-- <div class="row justify-content-center">
                    <div class="text-header font-size-18 font-weight-500 text-white">Profil</div>
                </div> --}}
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
                onclick="window.top.openFrame('{{ route('bidan.pasien.modal.identity', $user->id) }}', 'Identitas')"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Identitas
                    Pasien</button>
                <button type="button"
                onclick="window.top.openFrame('{{ route('bidan.pasien.modal.history.current.pregnancy', $user->id) }}', 'Riwayat Kehamilan Sekarang')"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat Kehamilan
                    Sekarang</button>
                <button type="button"
                onclick="window.top.openFrame('{{ route('bidan.pasien.modal.contraception-history', $user->id) }}', 'Riwayat Kontrasepsi')"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat
                    Kontrasepsi</button>
                <button type="button"
                onclick="window.top.openFrame('{{ route('bidan.pasien.modal.history.prev.pregnancy', $user->id) }}', 'Riwayat Kehamilan Sebelumnya')"
                    class="btn btn-block btn-profile bg-white text-active-pink font-weight-500">Riwayat Kehamilan
                    Sebelumnya</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <a href="#"
                    onclick="window.top.openFrame('{{ route('bidan.pasien.modal.physic.examination', $user->id) }}', 'Pemeriksaan Fisik')"
                    class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Pemeriksaan Fisik</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#"
                    onclick="openlabExamination()"
                    class="d-flex justify-content-between mb-29">
                    <span class="font-size-16 text-black font-weight-500">Pemeriksaan Lab</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
                <a href="#" class="d-flex justify-content-between mb-29"
                    onclick="openAction()">
                    <span class="font-size-16 text-black font-weight-500">Tindakan</span>
                    <img src="{{ asset('images/icon/next.png') }}" width="15" height="15">
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        function openlabExamination(){
            window.top.openFrame('{{ route('bidan.pasien.modal.lab.examination', $user->id) }}', 'Pemeriksaan Lab')
        }

        function openAction() {  
            window.top.openFrame('{{route('bidan.pasien.modal.action', $user->id)}}', 'Tindakan')
        }
    </script>
@endpush
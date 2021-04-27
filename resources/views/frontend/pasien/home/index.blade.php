@extends('frontend.layouts.app')
@section('content')
    <div class="home-card mb-37">
        <div class="buble buble1"></div>
        <div class="buble buble2"></div>
        <div class="container-mhealth" style="position: relative">
            <div class="row justify-content-between pt-3 mb-41">
                <div class="row">
                    <div class="ml-25 mr-5px">
                        <img src="{{ asset('images/logo/logo-mhealth.png') }}" alt="m-health" width="116px" height="31px">
                    </div>
                </div>
                <div class="mr-15">
                    <img src="{{ asset('images/icon/notification.png') }}" width="25" height="25">
                    {{-- <i class="fas fa-bell fa-lg text-white"></i> --}}
                </div>
            </div>
            <div class="text-white mb-34" style="position: relative;">
                <div>Halo ibu,</div>
                <h4 class="d-block font-weight-bold">{{$__userdata->fullname}}</h4>
            </div>


            <div class="card card-home">
                <div class="card-body shadow text-center" style="height: 150px">
                    <h6>Resiko Kehamilan</h6>
                    <div class="row justify-content-center mb-2">
                        <div class="col-auto">
                            <div class="text-red px-2 font-40px font-weight-bold border border-danger">TINGGI</div>
                        </div>
                    </div>
                    <p class="text-red text-card-top d-sm-inline-block">Anda memiliki resiko tinggi terhadap kesehatan ibu dan janin,
                        konsultasi secara rutin apabila diperlukan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-mhealth pb-5" style="max-height: 86vh; overflow: auto">
        <div class="d-flex justify-content-between mb-2">
            <div class="w-76 h-114" onclick="openFrame('{{route('pasien.modal.diary')}}','Diary Ibu Hamil')">
                <div class="box-home rounded bg-green mb-1px">
                    <div class="card-body ">
                        <img src="{{ asset('images/icon/diary.png') }}" width="38" height="38">
                    </div>
                </div>
                <p class="text-center font-xs lh-15">Diary ibu hamil</p>
            </div>
            <div class="w-76 h-114" onclick="openFrame('{{route('pasien.modal.pregnancy_test')}}','Pemeriksaan Kehamilan')">
                <div class="box-home rounded bg-blue mb-1px">
                    <div class="card-body ">
                        <img src="{{ asset('images/icon/pemeriksaan.png') }}" width="38" height="38">
                    </div>
                </div>
                <p class="text-center font-xs lh-15">Pemeriksaan Kehamilan</p>
            </div>
            <div class="w-76 h-114" onclick="openFrame('{{route('pasien.modal.health_records')}}','Catatan Kesehatan')">
                <div class="box-home rounded bg-red mb-1px">
                    <div class="card-body ">
                        <img src="{{ asset('images/icon/catatan.png') }}" width="38" height="38">
                        {{-- <i class="fas fa-list-ul fa-2x text-white"></i>  --}}
                    </div>
                </div>
                <p class="text-center font-xs lh-15">Catatan Kesehatan</p>
            </div>
            <div class="w-76 h-114" onclick="openFrame('{{route('pasien.modal.consultation')}}','Telekonsultasi')">
                <div class="box-home rounded bg-yellow mb-1px">
                    <div class="card-body ">
                        <img src="{{ asset('images/icon/telekonsultasi.png') }}" width="38" height="38">
                        {{-- <i class="fas fa-user-md fa-2x text-white"></i>  --}}
                    </div>
                </div>
                <p class="text-center font-xs lh-15">Telekonsultasi</p>
            </div>
        </div>

        <h4 class="font-weight-bold font-20 mt-4">Untuk ibu ketahui</h4>

        <hr>
        <div class="d-flex">
            <div class="mr-19 h-94 w-94 d-inline-block">
                <img src="https://akcdn.detik.net.id/visual/2019/09/18/fef8eda8-9c35-4d7d-ad09-058ba2b8d032_169.jpeg?w=650" class="rounded-4" width="94" height="94">
            </div>
            <div class="w-251 d-inline-block">
                <div class="text-pink d-inline-block">KEHAMILAN</div>
                <div class="font-weight-500 line-height-23 font-18px d-inline-block">
                    Kenali tanda - tanda pada kehamilan
                </div>
                <div class="d-inline-block font-14" style="color: #BBBBBB">11 Jam yang lalu</div>
            </div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="mr-19 h-94 w-94 d-inline-block">
                <img src="https://akcdn.detik.net.id/visual/2019/09/18/fef8eda8-9c35-4d7d-ad09-058ba2b8d032_169.jpeg?w=650" class="rounded-4" width="94" height="94">
            </div>
            <div class="w-251 d-inline-block">
                <div class="text-pink d-inline-block">KEHAMILAN</div>
                <div class="font-weight-500 line-height-23 font-18px d-inline-block">
                    Kenali tanda - tanda pada kehamilan
                </div>
                <div class="d-inline-block font-14" style="color: #BBBBBB">11 Jam yang lalu</div>
            </div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="mr-19 h-94 w-94 d-inline-block">
                <img src="https://akcdn.detik.net.id/visual/2019/09/18/fef8eda8-9c35-4d7d-ad09-058ba2b8d032_169.jpeg?w=650" class="rounded-4" width="94" height="94">
            </div>
            <div class="w-251 d-inline-block">
                <div class="text-pink d-inline-block">KEHAMILAN</div>
                <div class="font-weight-500 line-height-23 font-18px d-inline-block">
                    Kenali tanda - tanda pada kehamilan
                </div>
                <div class="d-inline-block font-14" style="color: #BBBBBB">11 Jam yang lalu</div>
            </div>
        </div>
    </div>
@endsection

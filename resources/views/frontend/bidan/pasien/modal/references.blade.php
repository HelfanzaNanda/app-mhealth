@extends('frontend.layouts.app')
@section('content')
<div class="pasien">
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
    <div class="mb-3" style="height: 86vh; overflow: hidden">
        <div class="container-mhealth mt-3 h-100">
            <form action="" class="references">
                @csrf
                <div class="form-group">
                    <label class="font-weight-500">Tanggal</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend ">
                            <span class="input-group-text bg-white border-pink" 
                            style="border-right: none !important">
                                <img src="{{ asset('images/icon/calendar.png') }}" width="22" height="22">
                            </span>
                        </div>
                        <input type="text" value="27 Maret 2021"
                        class="form-control text-pink text-center font-18px datepicker 
                        font-size-16 form-mhealth" 
                        style="border-left: none !important; border-right: none !important;">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-pink" id="basic-addon1"
                            style="border-left: none !important">
                                <img src="{{ asset('images/icon/arrow-down.png') }}" width="22" height="22">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Nama Pasien</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth" placeholder="Nama Lengkap">
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Nomor Surat</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth" placeholder="Nomor Surat">
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Tujuan</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth" placeholder="RS Tujuan">
                </div>
                <button class="btn btn-block bg-dark-pink btn-mhealth text-white mt-3" type="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $('.datepicker').datepicker({
            autoclose : true,
            format: 'dd/mm/yyyy'
        });
    </script>
@endpush

@extends('frontend.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="pasien">
    <div class="container box-shadow" style="height: 60px">
        <div class="hadow shadow-lg">
            <div class="justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500 text-center">Kunjungan</div>
            </div>
        </div>
    </div>
    <div class="bg-grey pt-23" style="height: 86vh; overflow: hidden">
        <div class="container-mhealth h-100">
            <form action="" class="visit h-100" id="kunjungan_form">
                @csrf
                <label class="font-weight-500">Tanggal Kunjungan</label>
                <div class="form-group has-warning has-feedback">
                    <div class="input-group-mhealth">
                        <span class="form-control-feedback-left">
                            <img src="{{ asset('images/icon/calendar.png') }}" width="22" height="22">
                        </span>
                        <input type="text" class="form-control 
                        text-pink text-center font-18px datepicker form-mhealth" name="date" id="date"
                            value="27 Maret 2021">
                        <span class="form-control-feedback-right">
                            <img src="{{ asset('images/icon/arrow-down.png') }}" width="22" height="22">
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Nama Pasien</label>
                    <select class="form-control font-size-16 form-mhealth select2Input" name="pasienId" id="pasienId">
                        <option value="0"></option>
                        @foreach ($data as $item)
                        <option value="{{ $item->pasienid }}">{{ $item->pasien->fullname }} - {{ $item->pasien->nik }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn bg-dark-pink text-white btn-mhealth btn-block" type="button"
                    onclick="Save()">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.datepicker').datepicker();
    $(document).ready(function() {
        $('.select2Input').select2();
    });

    async function Save() {
        console.log('test');
        const form = new FormData($('#kunjungan_form')[0]);
        const response = await axios.post('{{route('bidan.visit.save')}}', form);
        try {
            if(response.data.status != 1) {
                Swal.fire({
                    icon: 'warning',
                    text: response.data.msg
                });
                return;
            }
            Swal.fire({
                icon: 'success',
                text: 'Perubahan Disimpan'
            }).then( res => {
                console.log('berhasil');
                window.location.href='{{route('bidan.visit.index')}}';
            });
        } catch (error) {
            Swal.fire({
                icon: 'warning',
                text: error
            })
            console.log(error);
        }
    }
</script>
@endpush
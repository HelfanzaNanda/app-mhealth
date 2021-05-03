@extends('frontend.layouts.app')
@section('content')
<div class="container box-shadow" style="height: 60px">
    <div class="hadow shadow-lg">
        <div class="justify-content-center">
            <div class="text-header font-size-18 text-active-pink font-weight-500 text-center">Rujukan</div>
        </div>
    </div>
</div>
<div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
    <div class="container-mhealth ">
        <form action="" id="rujukan_form">
            @csrf
            <div class="form-group">
                <label class="font-weight-500">Tanggal Rujukan</label>
                <input type="text" readonly required name="tanggal_rujukan" class="bg-white form-control datepicker font-size-16 form-mhealth"
                value="{{ old('tanggal_rujukan') }}">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Ibu Hamil</label>
                <select name="pasienid" class="form-control font-size-16 form-mhealth">
                    <option value="" selected disabled>-- Pilih Ibu Hamil --</option>
                    @foreach ($moms as $mom)
                        <option value="{{ $mom->id }}">{{ $mom->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-500">Faskes</label>
                <select name="faskesid" class="form-control font-size-16 form-mhealth">
                    <option value="" selected disabled>-- Pilih Paskes --</option>
                    @foreach ($faskeses as $faskes)
                        <option value="{{ $faskes->id }}">{{ $faskes->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-500">No Surat</label>
                <input type="number" required name="no_surat" class="form-control font-size-16 form-mhealth"
                value="{{ old('no_surat') }}">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Upload Surat</label>
                <input type="file" required name="file" value="{{ old('file') }}"
                class="form-control font-size-16 form-mhealth">
            </div>
            <button class="btn btn-mhealth btn-block btn-pink text-white" type="button" onclick="Save()">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
         $(document).ready(function(){
        $('.datepicker').datepicker({
            autoclose : true,
            width: '100%',
            format: 'yyyy-mm-dd'
        });
    })

    async function Save() {
        const url = "{{ route('bidan.rujukan.store') }}";
        const form = new FormData($('#rujukan_form')[0]);
        try {
            const response = await axios.post(url, form);
            console.log(response);
            if(response.data.status != 1) {
                Swal.fire({ icon: 'warning', text: response.data.msg });
                return;
            }
            Swal.fire({ icon: 'success', text: 'Perubahan Disimpan' })
            .then( res => { window.location.reload() });
        } catch (error) {
            Swal.fire({ icon: 'warning', text: error })
        }
    }
    </script>
@endpush
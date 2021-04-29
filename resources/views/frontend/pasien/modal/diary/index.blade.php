@extends('frontend.layouts.app', [
'display' => 'd-none'
])
@section('content')
<div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
    <div class="container-mhealth ">
        <form action="" id="diary_form">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}">
            <div class="form-group">
                <label class="font-weight-500">Apa yang ibu rasakan hari ini ?</label>
                <input type="text" name="info1" id="info1" class="form-control font-size-16 form-mhealth"
                    value="{{ $data['info1'] }}">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Apa yang ibu makan dan minum hari ini ?</label>
                <input type="text" name="info2" id="info2" class="form-control font-size-16 form-mhealth"
                    value="{{ $data['info2'] }}">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Apakah ibu sudah minum obat / vitamin hari ini ?</label>
                <input type="text" name="info3" id="info3" class="form-control font-size-16 form-mhealth"
                    value="{{ $data['info3'] }}">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Bagaimana kondisi janin ibu hari ini ?</label>
                <input type="text" name="info4" id="info4" class="form-control font-size-16 form-mhealth"
                    value="{{ $data['info4'] }}">
            </div>
            <button class="btn btn-mhealth btn-block btn-pink text-white" type="submit" onclick="Save()">Simpan</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    async function Save() {
        // const url = "{{ route('pasien.diary.save') }}";
        const form = new FormData($('#diary_form')[0]);
        try {
            const response = await axios.post('{{route('pasien.diary.save')}}', form);
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
@endsection
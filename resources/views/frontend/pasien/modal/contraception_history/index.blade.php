@extends('frontend.layouts.app', [
'display' => 'd-none'
])
@section('content')
<div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
    <div class="container-mhealth ">
        <form action="" id="rk-form">
            @csrf
            <div class="form-group">
                <label class="font-weight-500">Riwayat kontrasepsi pada kehamilan saat ini</label>
                <input type="text" name="current_pregnancy" id="current_pregnancy"
                    class="form-control font-size-16 form-mhealth">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Riwayat kontrasepsi sebelum kehamilan saat ini</label>
                <input type="text" name="before_current_pregnancy" id="before_current_pregnancy"
                    class="form-control font-size-16 form-mhealth">
            </div>
            <button class="btn btn-mhealth btn-block btn-pink text-white" onclick="save()">Simpan</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    async function save() {
        const url = "{{ route('pasien.contraception_history.save') }}"
        const form = new FormData($('#rk-form')[0]);
        try {
            const response = await axios.post(url, form);
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
                $('#frame-modal').modal('hide');
                location.reload();
                // window.location.href = "{{ route('pasien.profile.index') }}"
            });
        } catch (error) {
            Swal.fire({
                icon: 'warning',
                text: error
            })
        }
    }
</script>
@endsection
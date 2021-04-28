@extends('frontend.layouts.app', [
'display' => 'd-none'
])
@section('content')
<div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
    <div class="container-mhealth ">
        <form action="" id="rp-form">
            @csrf
            <div class="form-group">
                <label class="font-weight-500">Keluhan</label>
                <input type="text" name="keluhan" id="keluhan" class="form-control font-size-16 form-mhealth">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Riwayat Penyakit Anda</label>
                <input type="text" name="riwayat_penyakit" id="riwayat_penyakit"
                    class="form-control font-size-16 form-mhealth">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Riwayat Penyakit Suami</label>
                <input type="text" name="riwayat_penyakit_suami" id="riwayat_penyakit_suami"
                    class="form-control font-size-16 form-mhealth">
            </div>
            <div class="form-group">
                <label class="font-weight-500">Riwayat KDRT</label>
                <input type="text" name="riwayat_kdrt" id="riwayat_kdrt" class="form-control font-size-16 form-mhealth">
            </div>
            <button class="btn btn-mhealth btn-block btn-pink text-white" onclick="save()">Simpan</button>
        </form>

        <div class="my-4">
            <div class="mb-2">
                Riwayat Kesehatan:
            </div>
            <div id="dataList">
                @foreach ($data as $item)
                <div class="input-group my-2">
                    <input class="form-control py-2" type="text" readonly
                        value="{{ $item->keluhan . ', ' . $item->riwayat_penyakit . ', ' . $item->riwayat_penyakit_suami . ', ' . $item->riwayat_kdrt }}">
                    <span class="input-group-append">
                        <button class="btn btn-outline-danger" onclick="Delete({{ $item->id }})">
                            <i class="fa fa-times"></i>
                        </button>
                    </span>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    loadList();
    function loadList() {
            $.ajax({
                type  : 'GET',
                url   : "{{ route('pasien.health_history.data') }}",
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = ``;
                    data.forEach(element => {
                        html += `<div class="input-group my-2">
                                    <input class="form-control py-2" type="text" readonly
                                        value="${element.keluhan}, aaa, ${element.riwayat_penyakit}, ${element.riwayat_penyakit_suami}, ${element.riwayat_kdrt}">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-danger" onclick="Delete(${element.id})">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>`;
                    });
                    // console.log(data);
                    $('#dataList').html(html);
                }
            });
        }

        // async function getData() {
        //     const url = "{{ route('pasien.health_history.data') }}";
        //     const response = await axios(url);
        //     return response.data;
        // }

        async function Delete(id) {
            const url = "{{ route('pasien.health_history.delete', '') }}" + "/" + id;
            try {
                const response = await axios.delete(url);
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
                    loadList();
                    // $('#frame-modal').modal('hide');
                    // location.reload();
                    // window.location.href = "{{ route('pasien.profile.index') }}"
                });
            } catch (error) {
                Swal.fire({
                    icon: 'warning',
                    text: error
                })
            }
        }

        async function save() {
            const url = "{{ route('pasien.health_history.save') }}"
            const form = new FormData($('#rp-form')[0]);
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
                    loadList();
                    // $('#frame-modal').modal('hide');
                    // location.reload();
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
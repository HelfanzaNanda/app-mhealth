@extends('frontend.layouts.app', [
'display' => 'd-none'
])
@section('content')
<div class="bg-grey pt-23 mt-1 overflow-y-auto" style="height: 100vh; overflow: hidden">
    <div class="container-mhealth ">
        <form action="" id="rp-form">
            @csrf
            <div class="form-group" id="listKeluhan">
                <label class="font-weight-500" for="itemKeluhan[]" id="labelKeluhan">
                    Keluhan
                </label>
                {{-- <input type="text" name="keluhan" id="keluhan" class="form-control font-size-16 form-mhealth"> --}}
                <div class="input-group mb-2">
                    <input class="form-control py-2" type="text" id="inputKeluhan" placeholder="Masukan keluhan anda">
                    <span class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="addKeluhan()" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group" id="listPenyakitAnda">
                <label class="font-weight-500" id="labelPenyakitAnda">Riwayat Penyakit Anda</label>
                {{-- <input type="text" name="riwayat_penyakit" id="riwayat_penyakit"
                    class="form-control font-size-16 form-mhealth"> --}}
                <div class="input-group mb-2">
                    <input class="form-control py-2" type="text" id="inputPenyakitAnda"
                        placeholder="Masukan riwayat penyakit anda">
                    <span class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="addPenyakitAnda()" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group" id="listPenyakitSuami">
                <label class="font-weight-500" id="labelPenyakitSuami">Riwayat Penyakit Suami</label>
                {{-- <input type="text" name="riwayat_penyakit_suami" id="riwayat_penyakit_suami"
                    class="form-control font-size-16 form-mhealth"> --}}
                <div class="input-group mb-2">
                    <input class="form-control py-2" type="text" id="inputPenyakitSuami"
                        placeholder="Masukan riwayat penyakit suami">
                    <span class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="addPenyakitSuami()" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group" id="listKDRT">
                <label class="font-weight-500" id="labelKDRT">Riwayat KDRT</label>
                {{-- <input type="text" name="riwayat_kdrt" id="riwayat_kdrt" class="form-control font-size-16 form-mhealth"> --}}
                <div class="input-group mb-2">
                    <input class="form-control py-2" type="text" id="inputKDRT" placeholder="Masukan riwayat KDRT">
                    <span class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="addKDRT()" type="button">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>
            <button class="btn btn-mhealth btn-block btn-pink text-white" type="button" onclick="save()">Simpan</button>
        </form>

        <div class="py-4">
            <div class="mb-2">
                Riwayat Kesehatan:
                {{-- loop --}}
                <div class="card box-shadow mb-2 card-0">
                    <div class="card-body">
                        <div class="row align-items-end ">
                            <div class="col-10">
                                <p>Date : </p>
                                <p>Penolong : </p>
                                <p>Tempat : </p>
                                <p>Persalinan : </p>
                            </div>
                            <div class="col-1">
                                <button data-key="0" data-id="0" class="btn btn-danger btn-remove-item btn-sm"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end loop --}}
            </div>
            <div id="dataList">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
    let indexKeluhan = 0;
    let indexPenyakitAnda = 0;
    let indexPenyakitSuami = 0;
    let indexKDRT = 0;
    
    $(document).on('click', '.removeKeluhan', function() {
        const key =$(this).data('key')
        $('.row-'+key+'-removeKeluhan').remove();
    });

    $(document).on('click', '.removePenyakitAnda', function() {
        const key =$(this).data('key')
        $('.row-'+key+'-removePenyakitAnda').remove();
    });

    $(document).on('click', '.removePenyakitSuami', function() {
        const key =$(this).data('key')
        $('.row-'+key+'-removePenyakitSuami').remove();
    });

    $(document).on('click', '.removeKDRT', function() {
        const key =$(this).data('key')
        $('.row-'+key+'-removeKDRT').remove();
    });

    function addKeluhan() {
        const keluhanValue = $('#inputKeluhan').val();
        if(keluhanValue != '') {
            $('#alertKeluhan').remove();
            $('#inputKeluhan').val("");
            // console.log(keluhanValue);
            indexKeluhan++;
            $('#listKeluhan').append(addListItem("listKeluhan[]", keluhanValue, indexKeluhan, 'removeKeluhan'));
            // console.log(indexKeluhan);
        } else {
            $('#labelKeluhan').after('<p class="text-danger" id="alertKeluhan"><small>Tulis keluhan dulu.</small></p>');
        }
    }

    function addPenyakitAnda() {
        const penyakitAndaValue = $('#inputPenyakitAnda').val();
        if(penyakitAndaValue != '') {
            $('#alertPenyakitAnda').remove();
            $('#inputPenyakitAnda').val("");
            indexPenyakitAnda++;
            $('#listPenyakitAnda').append(addListItem("listPenyakitAnda[]", penyakitAndaValue, indexPenyakitAnda, 'removePenyakitAnda'));
        } else {
            $('#labelPenyakitAnda').after('<p class="text-danger" id="alertPenyakitAnda"><small>Tulis penyakit anda dulu.</small></p>');
        }
    }

    function addPenyakitSuami() {
        const penyakitSuamiValue = $('#inputPenyakitSuami').val();
        if(penyakitSuamiValue != '') {
            $('#alertPenyakitSuami').remove();
            $('#inputPenyakitSuami').val("");
            indexPenyakitSuami++;
            $('#listPenyakitSuami').append(addListItem("listPenyakitSuami[]", penyakitSuamiValue, indexPenyakitSuami, 'removePenyakitSuami'));
        } else {
            $('#labelPenyakitSuami').after('<p class="text-danger" id="alertPenyakitSuami"><small>Tulis penyakit suami dulu.</small></p>');
        }
    }

    function addKDRT() {
        const KDRTValue = $('#inputKDRT').val();
        if(KDRTValue != '') {
            $('#alertKDRT').remove();
            $('#inputKDRT').val("");
            // console.log(KDRTValue);
            indexKDRT++;
            $('#listKDRT').append(addListItem("listKDRT[]", KDRTValue, indexKDRT, 'removeKDRT'));
            // console.log(indexKDRT);
        } else {
            $('#labelKDRT').after('<p class="text-danger" id="alertKDRT"><small>Tulis KDRT dulu.</small></p>');
        }
    }
 
    function addListItem(inputName, listValue, index, classRow) {
        let item = ''
            item  += '<div class="input-group my-1 row-'+index+'-'+classRow+'">'
            item  += '    <input class="form-control py-2" type="text" readonly name="'+inputName+'" value="'+listValue+'">'
            item  += '    <span class="input-group-append">'
            item  += '        <button data-key="'+index+'" class="btn btn-outline-danger '+classRow+'" type="button">'
            item  += '            <i class="fa fa-times"></i>'
            item  += '        </button>'
            item  += '    </span>'
            item  += '</div>'
        return item;
    }

    // loadList();
    // function loadList() {
    //     $.ajax({
    //         type  : 'GET',
    //         url   : "{{ route('pasien.health_history.data') }}",
    //         async : true,
    //         dataType : 'json',
    //         success : function(data){
    //             var html = ``;
    //             data.forEach(element => {
    //                 html += `<div class="input-group my-2">
    //                             <input class="form-control py-2" type="text" readonly
    //                                 value="${element.keluhan}, aaa, ${element.riwayat_penyakit}, ${element.riwayat_penyakit_suami}, ${element.riwayat_kdrt}">
    //                             <span class="input-group-append">
    //                                 <button class="btn btn-outline-danger" onclick="Delete(${element.id})">
    //                                     <i class="fa fa-times"></i>
    //                                 </button>
    //                             </span>
    //                         </div>`;
    //             });
    //             // console.log(data);
    //             $('#dataList').html(html);
    //         }
    //     });
    // }

    async function getData() {
        const url = "{{ route('pasien.health_history.data') }}";
        const response = await axios(url);
        return response.data;
    }

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
                // loadList();
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
@endpush
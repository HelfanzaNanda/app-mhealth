@extends('frontend.layouts.app')
@section('content')
<div class="pasien">
    {{-- <div class="container box-shadow bg-white">
        <div class="shadow shadow-lg">
            <div class="py-3">
                <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
            </div>
            <div class="row justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500">Tindakan</div>
            </div>
        </div>
    </div> --}}
    <div class="bg-grey pt-23" style="height: 86vh; overflow: auto">
        <div class="container-mhealth h-100">
            <form action="" id="tindakan_form">
                @csrf
                <input type="hidden" name="ibuHamilId" value="{{ $ibuHamil->id }}" id="ibuHamilId">
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="imunisasi" type="checkbox" id="imunisasiCheckbox">
                            <label class="form-check-label font-weight-500 font-size-16" for="imunisasiCheckbox">
                                Imunisasi TT
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="tablet" type="checkbox" id="tabletCheckbox">
                            <label class="form-check-label font-weight-500 font-size-16" for="tabletCheckbox">
                                Tablet FE
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body" id="listItems">
                        <label for="listObat[]" id="labelListObat">Obat</label>
                        <div class="input-group mb-2">
                            <input class="form-control py-2" type="text" id="inputList">
                            <span class="input-group-append">
                                <button class="btn btn-outline-primary" onclick="addList()" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-block bg-dark-pink btn-mhealth text-white" type="button"
                    onclick="Save()">Simpan</button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    let index = 0;

    function refreshForm() {
        $('#ibuHamilId').val("");
        $('#inputList').val("");
        $('#inputList').val("");
        $('#imunisasiCheckbox').prop("checked", false);
        $('#tabletCheckbox').prop("checked", false);
        for(let i = 0; i < index; i++) {
            $('.row-'+i).remove();
        }
    }

    function addList() {
        const listValue = $('#inputList').val();
        if(listValue != '') {
            $('#alertListObat').remove();
            $('#inputList').val("");
            // console.log(listValue);
            $('#listItems').append(addListItem(listValue));
            index++;
            console.log(index);
        } else {
            $('#labelListObat').after('<p class="text-danger" id="alertListObat"><small>Tulis nama obat dulu.</small></p>');
        }

    }

    function addListItem(listValue) {
        let item = ''
            item  += '<div class="input-group mb-2 row-'+index+'">'
            item  += '    <input class="form-control py-2" type="text" readonly name="listObat[]" value="'+listValue+'">'
            item  += '    <span class="input-group-append">'
            item  += '        <button data-key="'+index+'" class="btn btn-outline-danger remove" type="button">'
            item  += '            <i class="fa fa-times"></i>'
            item  += '        </button>'
            item  += '    </span>'
            item  += '</div>'
        return item;
    }

    async function Save() {
        const url = '{{ route('bidan.pasien.action.save') }}'
        const form = new FormData($('#tindakan_form')[0]);
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
                    // window.location.href = "{{ route('pasien.profile.index') }}"
                        refreshForm();
                    });
            } catch (error) {
                Swal.fire({
                    icon: 'warning',
                    text: error
                })
            }
    }
    
    $(document).on('click', '.remove', function() {
        const key =$(this).data('key')
        $('.row-'+key).remove();
    });
</script>
@endpush
@extends('frontend.layouts.app')
@section('content')
<div class="pasien">
    <div class="container box-shadow bg-white">
        <div class="shadow shadow-lg">
            <div class="py-3">
                <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
            </div>
            <div class="row justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500">Tindakan</div>
            </div>
        </div>
    </div>
    <div class="bg-grey pt-23" style="height: 86vh; overflow: auto">
        <div class="container-mhealth h-100">
            <form action="" id="tindakan_form">
                @csrf
                <input type="hidden" name="ibuHamilId" value="{{ $ibuHamil->id }}">
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="imunisasi" type="checkbox" id="flexCheckDefault1">
                            <label class="form-check-label font-weight-500 font-size-16" for="flexCheckDefault1">
                                Imunisasi TT
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="tablet" type="checkbox" id="flexCheckDefault2">
                            <label class="form-check-label font-weight-500 font-size-16" for="flexCheckDefault2">
                                Tablet FE
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body items">
                        <label for="listObat[]">Obat</label>
                        <div class="input-group mb-2 after-add-more">
                            <input class="form-control py-2" type="text" name="listObat[]">
                            <span class="input-group-append">
                                <button class="btn btn-outline-primary" onclick="addMore()" type="button">
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
                });
            } catch (error) {
                Swal.fire({
                    icon: 'warning',
                    text: error
                })
            }
    }

    let index = 0
    function addMore() {
        $('.items').append(addItem());
        index++
    }

    function addItem() { 
        let item = ''
            item  += '<div class="input-group mb-2 row-'+index+'">'
            item  += '    <input class="form-control py-2" type="text" name="listObat[]">'
            item  += '    <span class="input-group-append">'
            item  += '        <button data-key="'+index+'" class="btn btn-outline-danger remove" type="button">'
            item  += '            <i class="fa fa-times"></i>'
            item  += '        </button>'
            item  += '    </span>'
            item  += '</div>'
        return item
     }

    $(document).on('click', '.remove', function() {
        const key =$(this).data('key')
        $('.row-'+key).remove();
    });
</script>
@endpush
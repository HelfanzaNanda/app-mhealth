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
            <form action="">
                @csrf
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                            <label class="form-check-label font-weight-500 font-size-16" for="flexCheckDefault1">
                                Imunisasi TT
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
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
                <button class="btn btn-block bg-dark-pink btn-mhealth text-white" type="button">Simpan</button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
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
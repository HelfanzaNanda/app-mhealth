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
            <form action="{{ route('bidan.pasien.action.save') }}">
                @csrf
                <input type="hidden" name="ibuHamilId" value="{{ $ibuHamil->id }}">
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="imunisasi" type="checkbox" value=""
                                id="flexCheckDefault1">
                            <label class="form-check-label font-weight-500 font-size-16" for="flexCheckDefault1">
                                Imunisasi TT
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name="tablet" type="checkbox" value=""
                                id="flexCheckDefault2">
                            <label class="form-check-label font-weight-500 font-size-16" for="flexCheckDefault2">
                                Tablet FE
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 card-action">
                    <div class="card-body">
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

                {{-- hide --}}
                <div class="copy d-none">
                    <div class="input-group mb-2">
                        <input class="form-control py-2" type="text" name="listObat[]">
                        <span class="input-group-append">
                            <button class="btn btn-outline-danger remove" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <button class="btn btn-block bg-dark-pink btn-mhealth text-white" type="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    // function Simpan() {
    //     console.log('save');
    // }

    function addMore() {
        console.log('haloo');
        let html = $('.copy').html();
        $('.after-add-more').after(html);
        console.log('hehe');
    }

    $(document).on('click', '.remove', function() {
        console.log('delete');
        $(this).parent('.input-group').remove();
        console.log('berhasil');
    });
</script>
@endpush
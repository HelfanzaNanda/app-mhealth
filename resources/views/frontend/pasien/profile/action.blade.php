@extends('frontend.layouts.app')
@section('content')
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
    <div class="bg-grey pt-23 mt-n1" style="height: 86vh; overflow: auto">
        <div class="container-mhealth h-100">
            <div class="card box-shadow">
                <div class="card-body">
                    <form action="">
                        @csrf
                        <div class="form-check mb-23">
                            <input class="form-check-input" checked type="checkbox" value="" id="flexCheckDefault1">
                            <label class="form-check-label font-weight-500 font-size-500 ml-2" for="flexCheckDefault1">
                                Imunisasi TT
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" value="" id="flexCheckDefault1">
                            <label class="form-check-label font-weight-500 font-size-500 ml-2" for="flexCheckDefault1">
                                Konseling
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

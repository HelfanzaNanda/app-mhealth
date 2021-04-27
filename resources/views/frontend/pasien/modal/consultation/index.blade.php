@extends('frontend.layouts.app', [
    'display' => 'd-none'
])
@section('content')

    <div class="bg-grey pt-23 mt-1" style="height: 100vh">
        <div class="container-mhealth h-100">
            <div class="d-flex w-100 h-100 align-items-end">
                <div class="form-group w-100 has-warning has-feedback">
                    <div class="input-group-mhealth">
                        <input type="text" class="bg-form-auth form-control
                        font-size-16 form-mhealth"
                        placeholder="Tulis pesan anda ...">
                        <span class="form-control-feedback-right">
                            <img src="{{ asset('images/icon/send-button.png') }}" width="23" height="23">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.layouts.app')
@section('content')

    <div class="pt-23" style="max-height: 86vh; overflow: auto">
        <div class="container-mhealth ">
            {{-- <div class="form-group has-warning has-feedback">
                <div class="input-group-mhealth">
                    <span class="form-control-feedback-left">
                        <img src="{{ asset('images/icon/search.png') }}" width="22" height="22">
                    </span>
                    <input type="text" class="form-control 
                     pl-5 font-18px form-mhealth" 
                    placeholder="Cari Ibu Hamil">
                </div>
            </div> --}}
            <div style="flex-grow: 1;" >
                @foreach($notifications as $notification)
                    <div class="row align-items-center" 
                    onclick="openFrame('{{route('bidan.modal.notifikasi.detail', $notification->id)}}', 'Notifikasi')">
                        {{-- <div class="col-2">
                            <img src="{{ asset('images/profile.png') }}" class="image-chat-responsive">
                        </div> --}}
                        <div class="col-12">
                            <div class="font-weight-500 font-18px block">
                                {{$notification->subject}}
                            </div>
                            <div class="d-inline-block text-pink font-14">{{$notification->body}}</div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
@endsection
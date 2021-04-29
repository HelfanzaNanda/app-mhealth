@extends('frontend.layouts.app')
@section('content')
<div class="pasien">
    <div class="container box-shadow bg-white">
        <div class="col-12 shadow shadow-lg">
            <div class="py-3">
                <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
            </div>
            <div class="row justify-content-center">
                <div class="text-header font-size-18 text-active-pink">Profil</div>
            </div>
        </div>
    </div>
    <div class="bg-grey pt-23" style="height: 86vh; overflow: hidden">
        <div class="container-mhealth h-100" >
            <div class="card profile-bidan-card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="thumb-lg member-thumb mx-auto">
                            <img src="{{ asset('images/profile.png') }}" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>
                    </div>
                    <div class="text-white text-center mt-3">
                        <div class="font-size-24 text-pink font-weight-700">{{$data->fullname}}</div>
                        <h5 class="text-pink font-size-18">Bidan</h5>
                    </div>
                    <div class="text-center mx-2">
                        <button type="button" onclick="openIdentity()" class="btn btn-block btn-profile">Identitas Anda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function openIdentity(){
            openFrame('{{route('bidan.profile.modal.identity')}}','Profil',{
                button:{
                    text:'Edit',
                    onclick:function(){
                        openFrame('{{route('bidan.profile.modal.edit')}}','Edit Profil')
                    }
                }
            })
        }
    </script>
@endpush

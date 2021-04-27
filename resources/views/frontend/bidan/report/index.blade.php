@extends('frontend.layouts.app')
@section('content')
<div class="pasien">
    <div class="container box-shadow bg-white">
        <div class="py-3">
            <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
        </div>
        <div class="row justify-content-center">
            <div class="text-header font-size-18 text-active-pink">Laporan</div>
        </div>
    </div>
    <div class="bg-grey pt-23" style="height: 86vh; overflow: hidden">
        <div class="container-mhealth h-100" >
            <div class="card">
                <div class="card-body">
                    <h5>Laporan Dokter</h5>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush

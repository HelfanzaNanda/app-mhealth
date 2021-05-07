@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Riwayat kontrasepsi pada kehamilan saat ini</label>
                    <h6>{{ $data->current_pregnancy ?? '-' }}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Riwayat kontrasepsi sebelum kehamilan saat ini</label>
                    <h6>{{ $data->before_current_pregnancy ?? '-' }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

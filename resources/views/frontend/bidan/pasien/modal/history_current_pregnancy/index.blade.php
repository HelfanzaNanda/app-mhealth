@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Kehamilan</label>
                    <h6>{{$data->kehamilan ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Tanggal Haid Terakhir</label>
                    @if ($data)
                        <h6>{{ date("d M Y",strtotime($data->tanggal_haid_terakhir)) }}</h6>
                    @else
                        <h6>-</h6>
                    @endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">HPL</label>
                    <h6>{{$data->hpl ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Usia Kehamilan</label>
                    <h6>{{$data->usia_kehamilan ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Siklus Haid</label>
                    <h6>{{$data->siklus_haid ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pendarahan</label>
                    @if ($data)
                        <h6>{{$data->pendarahan ? 'ada' : 'tidak ada'}}</h6>  
                    @else
                        <h6>-</h6>
                    @endif
                    
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Keputihan</label>
                    @if ($data)
                    <h6>{{$data->keputihan ? 'ada' : 'tidak ada'}}</h6>    
                    @else
                        <h6>-</h6>
                    @endif
                    
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Keputihan Warna</label>
                    <h6>{{$data->keputihan_warna ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Keputihan Gatal</label>
                    @if ($data)
                    <h6>{{$data->keputihan_gatal ? 'ada' : 'tidak ada'}}</h6>    
                    @else
                        <h6>-</h6>
                    @endif
                    
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Mual</label>
                    <h6>{{$data->mual ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pemakaian Obat</label>
                    @if ($data)
                    <h6>{{$data->pemakaian_obat ? 'ada' : 'tidak ada'}}</h6>    
                    @else
                        <h6>-</h6>
                    @endif
                    
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Jenis Obat</label>
                    <h6>{{$data->jenis_obat ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Keluhan Lainnya</label>
                    <h6>{{$data->keluhan_lainnya ?? '-'}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

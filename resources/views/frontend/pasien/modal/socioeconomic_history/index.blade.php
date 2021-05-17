@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="form-group">
                    <label style="color: #bfbfbf">Usia Menikah </label>
                    <h6>{{$data->usia_menikah ?? '-' }}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Perkawinan Ke</label>
                    <h6>{{$data->perkawinanke ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Merokok </label>
                    @if ($data)
						<h6>{{$data->merokok == '1' ? 'merokok' : 'tidak merokok'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Alkohol</label>
                    @if ($data)
						<h6>{{$data->alkohol == '1' ? 'alkohol' : 'tidak alkohol'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Narkoba</label>
                    @if ($data)
						<h6>{{$data->narkoba == '1' ? 'narkoba' : 'tidak narkoba'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">HIV</label>
                    @if ($data)
						<h6>{{$data->hiv == '1' ? 'HIV' : 'tidak HIV'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Pencegahan Malaria</label>
                    @if ($data)
						<h6>{{$data->pencegahan_malaria == '1' ? 'pencegahan' : 'tidak pencegahan'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Riwayat Imunisasi</label>
                    @if ($data)
						<h6>{{$data->riwayat_imunisasi ?? '-'}}</h6>
					@else
						<h6>-</h6>
					@endif
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Riwayat Penyakit</label>
                    <h6>{{$data->riwayat_penyakit ?? '-'}}</h6>
                </div>
                <div class="form-group">
                    <label style="color: #bfbfbf">Gerakan Janin</label>
                    <h6>{{$data->gerakan_janin ?? '-'}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

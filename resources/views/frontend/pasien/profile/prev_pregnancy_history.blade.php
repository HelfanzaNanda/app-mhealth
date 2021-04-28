@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        <div class="card box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tempat</th>
                            <th>Penolong</th>
                            <th>Lama Persalinan</th>
                            <th>Jenis Persalinan</th>
                            <th>Usia Kehamilan</th>
                            <th>Komplikasi</th>
                            <th>Kondisi Anak</th>
                            <th>BB Lahir</th>
                            <th>Lama Menyusui</th>
                            <th>Kematian Anak</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($datas as $data)
                              <tr>
                                  <td>{{ $data->tanggal }}</td>
                                  <td>{{ $data->tempat }}</td>
                                  <td>{{ $data->penolong }}</td>
                                  <td>{{ $data->lama }}</td>
                                  <td>{{ $data->jenis }}</td>
                                  <td>{{ $data->usia }}</td>
                                  <td>{{ $data->komplikasi }}</td>
                                  <td>{{ $data->kondisi_anak }}</td>
                                  <td>{{ $data->bb_anak .' Kg' }}</td>
                                  <td>{{ $data->lama_menyusui_ekslusif }}</td>
                                  <td>{{ $data->kematian }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backoffice.layout.master')
@push('plugin-styles')
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}


@endpush
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
@endpush
@section('content')
<div id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <a href="{{route('backoffice.faskes.index')}}"><i class="fa fa-arrow-left"></i> Back</a>
  </div>
  <div class="loading" style="display: none">
    <div class="card">
      <div class="card-body text-center">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      </div>
    </div>
  </div>
  <div v-else>
    <div class="row">
      <div class="col-6 offset-3">
        <div class="card mb-1">
          <div class="card-header">
            <h5 class="card-title">
              <span>{{ $title }}</span>
            </h5>
          </div>
          <div class="card-body">
            <form id="notifikasi_form" action="">
              @csrf
              <input type="hidden" name="id" value="{{ $data['id'] }}">
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Nama</label>
                <div class="col-12 col-md-9">
                  <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ $data['nama'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">No HP</label>
                <div class="col-12 col-md-9">
                  <input type="text" name="no_hp" class="form-control" placeholder="No HP" value="{{ $data['nohp'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Email</label>
                <div class="col-12 col-md-9">
                  <input type="email" name="email" class="form-control" placeholder="Email"
                    value="{{ $data['email'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Alamat</label>
                <div class="col-12 col-md-9">
                  <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jalan Merdeka No.17"
                    value="{{ $data['alamat'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Provinsi</label>
                <div class="col-12 col-md-9">
                  <select class="form-control" id="provinsi" name="provinsi">
                    <option value="" selected>
                      {{ ($data['kabupaten'] != '') ? $data['kabupaten']->provinsi->provinsiName : '' }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Kabupaten</label>
                <div class="col-12 col-md-9">
                  <select class="form-control" id="kabupaten" name="kabupaten">
                    <option value="{{ ($data['kabupaten'] != '') ? $data['kabupaten']->kabupatenId : '' }}" selected>
                      {{ ($data['kabupaten'] != '') ? $data['kabupaten']->kabupatenName : '' }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Kecamatan</label>
                <div class="col-12 col-md-9">
                  <select class="form-control" id="kecamatan" name="kecamatan">
                    <option value="{{ ($data['kecamatan'] != '') ? $data['kecamatan']->kecamatanId : '' }}" selected>
                      {{ ($data['kecamatan'] != '') ? $data['kecamatan']->kecamatanName : '' }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Kelurahan</label>
                <div class="col-12 col-md-9">
                  <select class="form-control" id="kelurahan" name="kelurahan">
                    <option value="{{ ($data['kelurahan'] != '') ? $data['kelurahan']->kelurahanId : '' }}" selected>
                      {{ ($data['kelurahan'] != '') ? $data['kelurahan']->kelurahanName : '' }}
                    </option>
                  </select>
                </div>
              </div>
            </form>

          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <button class="btn btn-outline-success" onclick="save(true)">Save & Back</button>
              <button class="btn btn-success" onclick="save()">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $("#provinsi").append('<option value="">Pilih</option>');
    const urlGetProvinsi = '{{ route('backoffice.faskes.getProvinsi') }}';
    axios(urlGetProvinsi).then(res => {
      // console.log(res.data);
      res.data.forEach(element => {
        $('#provinsi').append('<option value=' + element.provinsiId + '>' + element.provinsiName + '</option>');
      });
    });

    $('#provinsi').change(function () {
      const provinsiId = $('#provinsi').val();
      const urlGetKabupaten = '{{ route('backoffice.faskes.getKabupaten', '') }}' + "/" + provinsiId;
      $('#kabupaten').html('');
      $('#kecamatan').html('');
      $('#kelurahan').html('');
      axios(urlGetKabupaten).then(res => {
        res.data.forEach(element => {
          $('#kabupaten').append('<option value=' + element.kabupatenId + '>' + element.kabupatenName + '</option>');
        });
      });
    });

    $('#kabupaten').change(function () {
      const kabupatenId = $('#kabupaten').val();
      const urlGetKecamatan = '{{ route('backoffice.faskes.getKecamatan', '') }}' + "/" + kabupatenId;
      $('#kecamatan').html('');
      $('#kelurahan').html('');
      axios(urlGetKecamatan).then(res => {
        res.data.forEach(element => {
          $('#kecamatan').append('<option value=' + element.kecamatanId + '>' + element.kecamatanName + '</option>');
        });
      });
    });

    $('#kecamatan').change(function () {
      const kecamatanId = $('#kecamatan').val();
      const urlGetKelurahan = '{{ route('backoffice.faskes.getKelurahan', '') }}' + "/" + kecamatanId;
      $('#kelurahan').html('');
      axios(urlGetKelurahan).then(res => {
        console.log(res.data);
        res.data.forEach(element => {
          $('#kelurahan').append('<option value=' + element.kelurahanId + '>' + element.kelurahanName + '</option>');
        });
      });
    });
    
  });

  function save(back = false){
        let form = new FormData($('#notifikasi_form')[0]);
        axios.post('{{route('backoffice.faskes.save')}}',form)
        .then(response => {
          console.log(response);
          if(response.data.status!=1){
              Swal.fire({
                icon:'warning',
                text:response.data.msg
              })
              return;
            }
            Swal.fire({
              icon:'success',
              text:'Saved!',
              showConfirmButton:false,
              timer:2000
            }).then(res=>{
              if(back){
                window.location.href='{{route('backoffice.faskes.index')}}';
                return
              }
              window.location.href='{{route('backoffice.faskes.insert')}}';
            });
        }).catch(error=>{
            Swal.fire({
                icon:'warning',
                text:error
            })
        })
    }
</script>
@endpush
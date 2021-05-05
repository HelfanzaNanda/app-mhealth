@extends('backoffice.layout.master')
@push('plugin-styles')
<link
  href="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css"
  rel="stylesheet" />
<link href="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.css" rel="stylesheet" />

@endpush
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.js"></script>
<script
  src="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js">
</script>

@endpush
@section('content')
<div id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <a href="{{route('backoffice.rujukan.index')}}"><i class="fa fa-arrow-left"></i> Back</a>
  </div>
  <div class="row">
    <div class="col-6 offset-3">
      <div class="card mb-1">
        <div class="card-header">
          <h5 class="card-title">
            <span>{{$title}}</span>
          </h5>
        </div>
        <div class="card-body">
          <form action="" id="rujukan_form">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $rujukan->id }}">
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Bidan</label>
              <div class="col-12 col-md-9">
                <input type="text" class="form-control" readonly value="{{ $rujukan->bidan->fullname }}">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Pasien</label>
              <div class="col-12 col-md-9">
                <input type="text" class="form-control" readonly value="{{ $rujukan->pasien->fullname }}">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Tanggal Rujukan</label>
              <div class="col-12 col-md-9">
                <input type="text" class="form-control" readonly value="{{ $rujukan->tanggal_rujukan }}">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Nomor Surat</label>
              <div class="col-12 col-md-9">
                <input type="text" class="form-control" readonly value="{{ $rujukan->no_surat }}">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Surat Rujukan</label>
              <div class="col-12 col-md-9">
                <a href="{{ route('backoffice.rujukan.download.surat-rujukan', $rujukan->upload_surat) }}"
                  class="btn btn-success">Download Surat</a>
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Tindakan</label>
              <div class="col-12 col-md-9">
                <input type="file" class="form-control" name="tindakan[]" required multiple
                  accept="image/*,application/pdf">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            <button class="btn btn-outline-success" type="button" onclick="Save(true)">Save & Back</button>
            <button class="btn btn-success" type="button" onclick="Save()">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  function Save(back = false) {
    let form = new FormData($('#rujukan_form')[0]);
        axios.post('{{route('backoffice.rujukan.save')}}',form)
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
                window.location.href='{{route('backoffice.rujukan.index')}}';
                return
              }
              window.location.href='{{route('backoffice.rujukan.detail', $rujukan->upload_surat)}}';
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
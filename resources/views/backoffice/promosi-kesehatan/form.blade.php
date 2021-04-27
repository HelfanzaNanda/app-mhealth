@extends('backoffice.layout.master')
@push('plugin-styles')
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">


@endpush
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

@endpush
@section('content')
<div id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <a href="{{route('backoffice.users.index')}}"><i class="fa fa-arrow-left"></i> Back</a>
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
              <span>{{$title}}</span>
            </h5>
          </div>
          <div class="card-body">
            <form id="pk-form" action="">
              @csrf
              <input type="hidden" name="id" value="{{ $data['id'] }}">
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Kategori</label>
                <div class="col-12 col-md-9">
                  <select name="kategori_id" id="">
                      <option value="">- Pilih Kategori -</option>
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}"
                            {{ $category->id == $data['kategori_id'] ? 'selected' : '' }}>
                            {{ $category->kategori }}
                          </option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Tanggal</label>
                <div class="col-12 col-md-9">
                  <input type="date" name="date" class="form-control" placeholder="Tanggal"
                  value="{{ $data['date'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Judul</label>
                <div class="col-12 col-md-9">
                  <input type="text" name="title" class="form-control" placeholder="Judul"
                  value="{{ $data['title'] }}">
                </div>
              </div>
              <div class="row">
                <label class="col-12 col-md-3 mt-2">Konten</label>
                <div class="col-12 col-md-9">
                  <textarea class="summernote form-control" id="body" name="body" placeholder="Konten">{!! $data['body'] !!}</textarea>
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
  $(document).ready(function() {
    $('.summernote').summernote({
        height: 100
    });
  });
  function save(back = false){
        let form = new FormData($('#pk-form')[0]);
        axios.post('{{route('backoffice.promosi-kesehatan.save')}}',form)
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
                window.location.href='{{route('backoffice.promosi-kesehatan.index')}}';
                return
              }
              window.location.href='{{route('backoffice.promosi-kesehatan.insert')}}';
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
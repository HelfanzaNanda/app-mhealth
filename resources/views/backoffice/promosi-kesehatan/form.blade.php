@extends('backoffice.layout.master')
@push('plugin-styles')
{{-- <link
  href="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css"
  rel="stylesheet" />
<link href="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.css" rel="stylesheet" /> --}}
{{-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-rich-text-editor/richtext.min.css') }}"> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
  integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

@endpush
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
{{-- <script src="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.js"></script>
<script
  src="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js">
</script> --}}
{{-- <script src="{{ asset('assets/plugins/jquery-rich-text-editor/jquery.richtext.js') }}"></script> --}}

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
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Judul</label>
              <div class="col-12 col-md-9">
                <input type="text" id="title" v-model="data.title" class="form-control" placeholder="Judul">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Konten</label>
              <div class="col-12 col-md-9">
                <textarea id="summernote" v-model="data.body" name="body" class="summernote form-control"></textarea>
              </div>
            </div>
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
  var app = new Vue({
      el:'#content',
      data:{
        isLoading:false,
        isSaving:false,
        data:@json($data),
      },
      computed:{
      },
      watch:{
      },
      created() {
        $(document).ready(function() {
          $('.summernote').summernote();
        });
      },
      mounted(){
      },
      methods:{
        async Save(back=false){
          this.isSaving=true;

          await axios.post('{{route('backoffice.kategori.save')}}',this.data)
          .then(response=>{
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
                window.location.href='{{route('backoffice.kategori.index')}}';
                return
              }
              window.location.href='{{route('backoffice.kategori.insert')}}';
            });
          })
          .catch(error=>{
            console.log(error)
          })
          this.isSaving=false;
        },
      },
      updated(){
      }
    })
</script>
@endpush
@extends('backoffice.layout.master')
@push('plugin-styles')
{{-- <link
  href="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css"
  rel="stylesheet" />
<link href="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-rich-text-editor/richtext.min.css') }}">

@endpush
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
{{-- <script src="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.js"></script>
<script
  src="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js">
</script> --}}
<script src="{{ asset('assets/plugins/jquery-rich-text-editor/jquery.richtext.js') }}"></script>

@endpush
@section('content')
<div id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <a href="{{route('backoffice.users.index')}}"><i class="fa fa-arrow-left"></i> Back</a>
  </div>
  <div v-if="isLoading">
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
                <input type="text" v-model="data.title" class="form-control" placeholder="Judul">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2">Konten</label>
              <div class="col-12 col-md-9">
                <textarea class="richtext form-control" v-model="data.body" placeholder="Konten"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <button class="btn btn-outline-success" @click="Save(true)">Save & Back</button>
              <button class="btn btn-success" @click="Save()">Save</button>
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
  $('.richtext').richText({
    // text formatting
  bold: true,
  italic: true,
  underline: true,
  });
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
      mounted(){
      },
      methods:{
        async Save(back=false){
          this.isSaving=true;

          await axios.post('{{route('backoffice.promosi-kesehatan.save')}}',this.data)
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
                window.location.href='{{route('backoffice.promosi-kesehatan.index')}}';
                return
              }
              window.location.href='{{route('backoffice.promosi-kesehatan.insert')}}';
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
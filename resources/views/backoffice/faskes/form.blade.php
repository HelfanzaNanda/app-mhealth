@extends('backoffice.layout.master')
@push('plugin-styles')
  <link href="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" />
  <link href="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.css" rel="stylesheet" />

@endpush
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="http://localhost/git/ethnic-india-admin/public/assets/plugins/select2/select2.min.js"></script>
  <script src="http://localhost/git/ethnic-india-admin/public/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

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
              <label class="col-12 col-md-3 mt-2" >Nama</label>
              <div class="col-12 col-md-9">
                <input type="text" v-model="data.name" class="form-control" placeholder="Nama">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2" >Email</label>
              <div class="col-12 col-md-9">
                <input type="email" v-model="data.email" class="form-control" placeholder="Email" autocomplete="off">
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2" >Role</label>
              <div class="col-12 col-md-9">
                <select type="date" v-model="data.role" class="form-control" >
                  <option value="pasien">Ibu Hamil</option>
                  <option value="bidan">Bidan</option>
                  <option value="kia">KIA</option>
                  <option value="dinkes">Dinkes</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="row">
              <label class="col-12 col-md-3 mt-2" >Password</label>
              <div class="col-12 col-md-9">
                <input type="password" v-model="data.password" class="form-control" placeholder="New password" autocomplete="off">
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

          await axios.post('{{route('backoffice.users.save')}}',this.data)
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
                window.location.href='{{route('backoffice.users.index')}}';
                return
              }
              this.data.id=response.data.id;
              window.location.href='{{route('backoffice.users.edit','')}}/'+this.data.id;
            
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

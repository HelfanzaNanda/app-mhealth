@extends('backoffice.layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page" id="app">
    <div class="col-md-8 col-xl-5 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-12">
            <div class="auth-form-wrapper px-5 py-5">
              <a href="#" class="ethinc-india-logo d-block mb-2">mHealth<span>App</span></a>
              <h5 class="text-muted font-weight-normal mb-4">Welcome back admin! Log in to your account.</h5>
              <form class="forms-sample" @submit="Login($event)">
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" placeholder="Email" v-model="formLogin.username">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" autocomplete="current-password" placeholder="Password" v-model="formLogin.password">
                </div>
                <!-- <div class="form-check form-check-flat form-check-primary">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Remember me
                  </label>
                </div> -->
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0" :disabled="isLoading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="isLoading"></span>
                    Login
                  </button>
                </div>
              </form>
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
    el:"#app",
    data:{
      formLogin:{
        username:'',
        password:'',
      },
      isLoading:false,
    },
    mounted(){
      eiApi.checkJwt().then(response=>{
        // console.log(response);
        if(response){
          setTimeout(()=>{
            window.location.href="{{url('/')}}";

          },1000);
        }
      })
      
    },
    methods:{
      async Login($e){
        $e.preventDefault();
        this.isLoading=true;
        await eiApi.post('admin/login',this.formLogin)
          .then(response=>{
            if(response.data.status==false){
              Swal.fire({
                icon:'warning',
                text:response.data.msg,
                showConfirmButton:false,
                timer:2000,
              })
              return;
            }
            // console.log(response.data.jwt);
            eiApi.saveJwt(response.data.jwt);
            eiApi.checkJwt();
            // window.location.href='{{url('/')}}';
            setTimeout(()=>{
              window.location.href="{{url('/backoffice')}}";

            },1000);

          })
          .catch(err=>{
            console.log(err);
          })
        this.isLoading=false;
      }
    }
  })
</script>
@endpush
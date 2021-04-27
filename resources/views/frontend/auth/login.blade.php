<!doctype html>
<html lang="en">
  @include('frontend.layouts._head')
  <body>
    <div >
        <div class="container-mhealth">
            <div class="mb-4">
                <div class="shadow shadow-lg">
                    
                    <a href="{{route('welcome')}}" class="py-3 btn-back position-absolute" aria-hidden="true" >
                        <!-- <div class=""> -->
                            <img src="{{ asset('images/icon/back.png') }}" width="18" height="18" id="frame-back-img">
                        <!-- </div> -->
                    </a>
                    <div class="justify-content-center w-100 text-center py-3" >
                        <div class="d-inline-flex">
                            <div class="mr-2">
                                <img src="{{ asset('images/logo/mhealth.png') }}" alt="m-health" width="20">
                            </div>
                            <div class="text-active-pink font-weight-500 font-size-19"><b>mHealth</b></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-center">
                <div class="font-size-24 font-weight-700">Masuk</div>
                <p>Ibu belum punya akun? <a href="{{route('register',$role)}}" class="text-pink"><u>Daftar</u></a></p>
            </div>

            <form id="form-login" method="POST" class="mb-4 form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="font-weight-500" for="email">Username</label>
                    <input type="text" class="form-control bg-form-auth font-size-16 form-mhealth" 
                    name="email" id="email">
                </div>
                <label class="font-weight-500" for="password">Password</label>
                <div class="form-group has-warning has-feedback">
                    <div class="input-group-mhealth">
                        <input type="text" class="bg-form-auth form-control 
                        font-size-16 form-mhealth" name="password">
                        <span class="form-control-feedback-right">
                            <img src="{{ asset('images/icon/hide-password.png') }}" alt="">
                        </span>
                    </div>
                </div>
                <div class="text-right mb-3"><a href="" class="text-black font-size-14"><u>Forgot Password ?</u></a></div>
                <button class="btn btn-mhealth bg-dark-pink text-white btn-block" type="button" onclick="submitLogin()">Masuk Sekarang</button>
            </form>
            <!-- <p class="text-center">ibu juga bisa masuk dengan</p>
            <div class="row justify-content-center">
                <div>
                    <img src="https://www.freepnglogos.com/uploads/google-logo-png/google-logo-png-google-logos-vector-eps-cdr-svg-download-10.png"
                    alt="Google" width="40">
                </div>
                <div>
                    <img src="https://pngimg.com/uploads/facebook_logos/facebook_logos_PNG19754.png"
                    alt="Facebook" width="40">
                </div>
            </div> -->
        </div>
    </div>
    @include('frontend.layouts._script')
    <script type="text/javascript">
        function submitLogin(){
            var form = new FormData($('#form-login')[0]);
            axios.post('{{route('login.submit',$role)}}',form)
            .then(res=>{
                if(res.data.status!=1){
                    Swal.fire({
                        icon:'warning',
                        text:res.data.msg
                    })
                    return
                }
                window.location.reload();
            })
        }
    </script>
  </body>
</html>

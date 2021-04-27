<!doctype html>
<html lang="en">
  @include('frontend.layouts._head')
  <body>
    <div class="mt-3">
        <div class="container-mhealth" style="overflow: hidden">
            <div class="row mb-4">
                <div class="shadow shadow-lg">
                    <div class="">
                        <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
                    </div>
                    <div class="row justify-content-center w-100" style="position: absolute; top: 15px;">
                        <div class="mr-2">
                            <img src="{{ asset('images/logo/mhealth.png') }}" alt="m-health" width="20">
                        </div>
                        <div class="text-active-pink font-weight-500 font-size-19"><b>mHealth</b></div>
                    </div>
                </div>
            </div>

            <div class="mb-4 text-center">
                <div class="font-size-24 font-weight-700">Daftar</div>
                <p>Ibu sudah punya akun? <a href="" class="text-pink"><u>Masuk</u></a></p>
            </div>

            <form id="form-register" method="POST" class="mb-4">
                @csrf
                <div class="mb-2">
                    <label class="font-weight-500" for="fullname">Nama Lengkap</label>
                    <input type="text" class="form-control bg-form-auth font-size-16 form-mhealth" name="fullname" id="fullname">
                </div>
                @if($role=='pasien')
                <div class="mb-2">
                    <label class="font-weight-500" for="nik">NIK</label>
                    <input type="number" class="form-control bg-form-auth font-size-16 form-mhealth" name="nik" id="nik">
                </div>
                @elseif($role=='bidan')
                <div class="mb-2">
                    <label class="font-weight-500" for="sipb">SIPB</label>
                    <input type="text" class="form-control bg-form-auth font-size-16 form-mhealth" name="sipb" id="sipb">
                </div>
                @endif
                <div class="mb-2">
                    <label class="font-weight-500" for="email">Email</label>
                    <input type="email" class="form-control bg-form-auth font-size-16 form-mhealth" name="email" id="email">
                </div>
                <label class="font-weight-500" for="password">Password</label>
                <div class="form-group has-warning has-feedback">
                    <div class="input-group-mhealth">
                        <input type="text" class="bg-form-auth form-control 
                        font-size-16 form-mhealth" name="password" id="password">
                        <span class="form-control-feedback-right" onclick="showHidePass(this)">
                            <img src="{{ asset('images/icon/hide-password.png') }}" alt="">
                        </span>
                    </div>
                </div>
                <label class="font-weight-500" for="password">Konfirmasi Password</label>
                <div class="form-group has-warning has-feedback">
                    <div class="input-group-mhealth" name="confirm_password" id="confirm_password">
                        <input type="text" class="bg-form-auth form-control 
                        font-size-16 form-mhealth" name="confirm_password">
                        <span class="form-control-feedback-right" onclick="showHidePass(this)">
                            <img src="{{ asset('images/icon/hide-password.png') }}" alt="">
                        </span>
                    </div>
                </div>
                <div class="form-check py-3">
                    <input type="checkbox" class="form-check-input" id="perms">
                    <label class="form-check-label font-size-14" for="perms">
                        Saya menyatakan telah membaca dan menyetujui ketentuan dalam mobile health ini.
                    </label>
                </div>
                <button class="btn bg-dark-pink text-white btn-block" onclick="submitRegister()" type="button">Daftar Sekarang</button>
            </form>
        </div>
    </div>
    @include('frontend.layouts._script')
    <script type="text/javascript">
        function showHidePass(el){
            // $(el).
        }
        function submitRegister(){
            var form = new FormData($('#form-register')[0]);
            axios.post('{{route('register.submit',$role)}}',form)
            .then((res)=>{
                if(res.data.status!=1){
                    Swal.fire({
                        icon:'warning',
                        text:res.data.msg
                    })
                    return
                }
                window.location.href="{{route('login',$role)}}"
            })
        }
    </script>
  </body>
</html>

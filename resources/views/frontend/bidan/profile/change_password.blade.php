@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">Password Baru</label>
                    <input type="password" required name="password" id="password" 
                    class="form-control font-size-16 form-mhealth" placeholder="Password Baru">
                </div>
                <div class="form-group">
                    <label for="">Konfirmasi Password Baru</label>
                    <input type="password" required name="password_confirmation" id="password_confirmation" 
                    class="form-control font-size-16 form-mhealth" placeholder="Konfirmasi Password Baru">
                </div>

                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="simpanProfile()">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        async function simpanProfile(){
            const form = new FormData($('#form-edit')[0]);
            const response = await axios.post('{{route('bidan.profile.password.change')}}',form)
            try {
                if (response.data.status != 1) {
                    Swal.fire({ icon:'warning', text:res.data.msg }) 
                    return
                }
                Swal.fire({ icon:'success', text:'Prubahan disimpan' })
                .then(res=>{ window.top.backButton() })    
            } catch (error) {
                Swal.fire({ icon:'warning', text:error })
            }
        }
    </script>
    @endpush
@endsection

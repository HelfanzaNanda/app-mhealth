@extends('frontend.layouts.app', [
    'display' => 'd-none'
])
@section('content')
    <div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
        <div class="container-mhealth " >
            <form id="form-insert">
                <input type="hidden" name="encrypted" id="encrypted" value="">
                @csrf
                <div class="form-group">
                    <label class="font-weight-500">NIK/Email</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" class="form-control font-size-16 form-mhealth" placeholder="ketikan email / nik ibu hamil">
                        <div class="input-group-append">
                            <button class="btn btn-pink" type="button" onclick="loadProfile(this)">Cari</button>
                        </div>
                    </div>
                </div>
                <div id="preview" class="py-4">
                    <p class="text-secondary text-center">Masukan NIK atau email ibu hamil yang terdaftar dalam di mHelath</p>
                </div>
                <button class="btn btn-mhealth btn-block btn-pink text-white" type="button" id="insert-btn" onclick="submitInsert(this)" disabled="">Tambahkan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        async function loadProfile(el){
            $(el).attr('disabled',true);
            await axios.post('{{route('data.pasien')}}',{username:$('#username').val()})
            .then(res=>{
                if(res.data.status!=1){
                    $('#encrypted').val('');
                    $('#insert-btn').attr('disabled',true)
                    $('#preview').html(res.data.msg);

                    return
                }
                $('#encrypted').val(res.data.encrypted);
                $('#insert-btn').removeAttr('disabled')
                $('#preview').html(res.data.result);
            }).catch(error=>{
                Swal.fire({
                    icon:'warning',
                    text:error
                })
            }) 
            $(el).removeAttr('disabled');
        }
        async function submitInsert(el){
            var form = new FormData($('#form-insert')[0]);
            $(el).attr('disabled',true);
            await axios.post('{{route('bidan.pasien.save')}}',form)
            .then(res=>{
                if(res.data.status!=1){
                    Swal.fire({
                        icon:'warning',
                        text:res.data.msg
                    })
                    return
                }
                Swal.fire({
                    icon:'success',
                    text:'Ditambahkan'
                }).then(res=>{
                    window.location.reload();
                })
            }).catch(error=>{
                Swal.fire({
                    icon:'warning',
                    text:error
                })
            })
            $(el).removeAttr('disabled');

        }

    </script>
    @endpush
@endsection

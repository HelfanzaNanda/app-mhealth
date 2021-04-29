@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">SIPB</label>
                    <input type="text" name="sipb" id="sipb" 
                    class="form-control font-size-16 form-mhealth" placeholder="SIPB"
                    value="{{ $data->sipb }}">
                </div>
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="nama" id="nama" 
                    class="form-control font-size-16 form-mhealth" placeholder="Nama Lengkap"
                    value="{{ $data->fullname }}">
                </div>
                <div class="form-group">
                    <label for="">No HP</label>
                    <input type="text" name="nohp" id="nohp" class="form-control font-size-16 form-mhealth" 
                    placeholder="08123456789" value="{{ $data->nohp }}">
                </div>
                <div class="form-group">
                    <label for="">Alamat</label>
                    <div class="mb-1">
                        <select name="provinsiid" id="provinsiid" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                            <option value="">Pilih Provinsi</option>
                            @foreach($list_provinsi as $row)
                            <option value="{{$row->provinsiId}}">{{$row->provinsiName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <select name="kabupatenid" id="kabupatenid" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                            <option value="">Pilih Kabupaten</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <select name="kecamatanid" id="kecamatanid" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <select name="kelurahanid" id="kelurahanid" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <textarea type="text" name="alamat" id="alamat" class="form-control font-size-16 form-mhealth" 
                        placeholder="Alamat" rows="5">{{ $data->alamat }}</textarea>
                    </div>
                </div>
                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="simpanProfile()">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            @foreach($data->toArray() as $key=>$value)
            $('#{{$key}}').val('{{$value}}');
            @endforeach
            $('#provinsiid').trigger('input');
        })

        $('#provinsiid').on('input',async function(){

            var provinsiid = $('#provinsiid').val();
            var oldId = '{{$data->kabupatenid}}';
            $('#provinsiid').attr('disabled',true);
            $('#kabupatenid').attr('disabled',true);
            await axios.post('{{route('data.kabupaten')}}',{provinsiid:provinsiid})
            .then(res=>{
                $('#kabupatenid').html(res.data.result);
                $('#kabupatenid').val(oldId)
                $('#kabupatenid').trigger('input');
            })
            $('#provinsiid').removeAttr('disabled');
            $('#kabupatenid').removeAttr('disabled');

        })

        $('#kabupatenid').on('input',async function(){

            var kabupatenid = $('#kabupatenid').val();
            var oldId = '{{$data->kecamatanid}}';

            $('#kabupatenid').attr('disabled',true);
            $('#kecamatanid').attr('disabled',true);
            await axios.post('{{route('data.kecamatan')}}',{kabupatenid:kabupatenid})
            .then(res=>{
                $('#kecamatanid').html(res.data.result);
                $('#kecamatanid').val(oldId)
                $('#kecamatanid').trigger('input');
            })
            $('#kecamatanid').removeAttr('disabled');
            $('#kabupatenid').removeAttr('disabled');

        })
        $('#kecamatanid').on('input',async function(){

            var kecamatanid = $('#kecamatanid').val();
            var oldId = '{{$data->kelurahanid}}';

            $('#kecamatanid').attr('disabled',true);
            $('#kelurahanid').attr('disabled',true);
            await axios.post('{{route('data.kelurahan')}}',{kecamatanid:kecamatanid})
            .then(res=>{
                $('#kelurahanid').html(res.data.result);
                $('#kelurahanid').val(oldId)
                $('#kelurahanid').trigger('input');
            })
            $('#kelurahanid').removeAttr('disabled');
            $('#kecamatanid').removeAttr('disabled');

        })
       async function simpanProfile(){
            const form = new FormData($('#form-edit')[0]);
            const response = await axios.post('{{route('bidan.profile.update')}}',form)
            try {
                if(response.data.status!=1){
                    Swal.fire({ icon:'warning', text:response.data.msg })
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

@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="nama" id="nama" 
                    class="form-control font-size-16 form-mhealth" placeholder="Nama Lengkap"
                    value="{{ $user->fullname }}">
                </div>
                <div class="form-group">
                    <label for="">Tempat, Tanggal Lahir</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" name="tempatlahir" id="tempatlahir" class="form-control font-size-16 form-mhealth" placeholder="Jakarta">
                        </div>
                        <div class="col-6">
                            <input type="date" name="tanggallahir" id="tanggallahir" class="form-control font-size-16 form-mhealth" placeholder="Jakarta, 20 Mei 1996">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">No HP</label>
                    <input type="text" name="nohp" id="nohp" class="form-control font-size-16 form-mhealth" 
                    placeholder="08123456789" value="{{ $user->nohp }}">
                </div>
                <div class="form-group">
                    <label for="">Agama</label>
                    <select name="agama" id="agama" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="Islam">Islam</option>
                        <option value="Konghucu">Konghucu</option>
                        <option value="Budha">Budha</option>
                        <option value="Katholik">Katholik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Suku (opsional)</label>
                    <input type="text" name="suku" id="suku" class="form-control font-size-16 form-mhealth" placeholder="mis. Jawa, Batak ">
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
                        placeholder="Alamat" rows="5">{{ $user->alamat }}</textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label for="">Situasi Keluarga</label>
                    <select name="keluarga" id="keluarga" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="Tinggal Sendiri">Tinggal Sendiri</option>
                        <option value="Tinggal Berama Keluarga">Tinggal Bersama Keluarga</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pendidikan</label>
                    <select name="pendidikan" id="pendidikan" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option >SD</option>
                        <option >SMP</option>
                        <option >SMA</option>
                        <option >Diploma</option>
                        <option >Sarjana</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control font-size-16 form-mhealth" placeholder="Pegawai Swasta">
                </div>
                <!-- <div class="form-group">
                    <label for="">Data Keluarga</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth" placeholder="Data Keluarga">
                </div> -->
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
        function simpanProfile(){
            var form = new FormData($('#form-edit')[0]);
            axios.post('{{route('pasien.profile.update')}}',form)
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
                    text:'Prubahan disimpan'
                }).then(res=>{
                    window.top.backButton()
                    //window.location.reload();
                })
            }).catch(error=>{
                Swal.fire({
                    icon:'warning',
                    text:error
                })
            })
        }
    </script>
    @endpush
@endsection

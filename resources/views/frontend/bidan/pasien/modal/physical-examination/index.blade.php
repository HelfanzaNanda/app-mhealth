@extends('frontend.layouts.frame')
@section('content')

<div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth pt-2">
        <form id="form-edit">
            @csrf
            <input type="hidden" name="pasienid" value="{{ $pasien_id }}">
            <div class="form-group">
                <label for="">Tanggal</label>
                <input type="text" name="date" required readonly
                    class="form-control font-size-16 datepicker bg-white form-mhealth" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <label for="">Tinggi Badan</label>
                <input type="number" name="tb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tinggi Badan">
            </div>
            <div class="form-group">
                <label for="">Berat Badan</label>
                <input type="number" name="bb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Berat Badan" >
            </div>
            <div class="form-group">
                <label for="">Conjuctiva</label>
                <select name="conjuctiva" required class="form-control font-size-16 form-mhealth">
                    <option value="0">Pilih Conjuctiva</option>
                    <option value="pucat"> Pucat </option>
                    <option value="tidak"> Tidak </option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Skelera</label>
                <select name="skelera" required class="form-control font-size-16 form-mhealth">
                    <option value="0">Pilih Skelera</option>
                    <option value="kuning">Kuning</option>
                    <option value="tidak" >Tidak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Kelopak Mata</label>
                <input type="text" name="kelopak_mata" required class="form-control font-size-16 form-mhealth"
                    placeholder="Kelopak Mata" >
            </div>

            <div class="form-group">
                <label for="">Darah HG</label>
                <input type="text" name="darah_hg" required class="form-control font-size-16 form-mhealth"
                    placeholder="Darah HG" >
            </div>

            <div class="form-group">
                <label for="">Darah HB</label>
                <input type="text" name="darah_hb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Darah HB" >
            </div>

            <div class="form-group">
                <label for="">Suhu</label>
                <input type="text" name="suhu" required class="form-control font-size-16 form-mhealth"
                    placeholder="Suhu" >
            </div>

            <div class="form-group">
                <label for="">Nadi</label>
                <input type="text" name="nadi" required class="form-control font-size-16 form-mhealth"
                    placeholder="Nadi" >
            </div>

            <div class="form-group">
                <label for="">Pernafasan</label>
                <input type="text" name="pernafasan" required class="form-control font-size-16 form-mhealth"
                    placeholder="Pernafasan" >
            </div>

            <div class="form-group">
                <label for="">Mulut</label>
                <input type="text" name="mulut" required class="form-control font-size-16 form-mhealth"
                    placeholder="Mulut" >
            </div>

            <div class="form-group">
                <label for="">Telinga</label>
                <input type="text" name="telinga" required class="form-control font-size-16 form-mhealth"
                    placeholder="Telinga" >
            </div>

            <div class="form-group">
                <label for="">Hidung</label>
                <input type="text" name="hidung" required class="form-control font-size-16 form-mhealth"
                    placeholder="Hidung" >
            </div>

            <div class="form-group">
                <label for="">Tenggorokan</label>
                <input type="text" name="tenggorokan" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tenggorokan" >
            </div>

            <div class="form-group">
                <label for="">Tinggi Fundus</label>
                <input type="text" name="tinggi_fundus" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tinggi Fundus" >
            </div>

            <div class="form-group">
                <label for="">Ballotement</label>
                <input type="text" name="ballotement" required class="form-control font-size-16 form-mhealth"
                    placeholder="Ballotement" >
            </div>

            <div class="form-group">
                <label for="">Posisi Janin</label>
                <input type="text" name="posisi_janin" required class="form-control font-size-16 form-mhealth"
                    placeholder="Posisi Janin" >
            </div>

            <div class="form-group">
                <label for="">Pergerakan Janin</label>
                <input type="text" name="pergerakan_janin" required class="form-control font-size-16 form-mhealth"
                    placeholder="Pergerakan Janin" >
            </div>

            <div class="form-group">
                <label for="">Denyut Jantung</label>
                <input type="text" name="jantung_denyut" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Jantung" >
            </div>

            <div class="form-group">
                <label for="">Denyut Frekuensi</label>
                <input type="text" name="jantung_frekuensi" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Frekuensi" >
            </div>

            <div class="form-group">
                <label for="">Denyut Irama</label>
                <input type="text" name="jantung_irama" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Irama" >
            </div>

            <div class="form-group">
                <label for="">Genitalia</label>
                <input type="text" name="genitalia" required class="form-control font-size-16 form-mhealth"
                    placeholder="Genitalia" >
            </div>

            <div class="form-group">
                <label for="">Extermitas</label>
                <input type="text" name="extermitas" required class="form-control font-size-16 form-mhealth"
                    placeholder="Extermitas" >
            </div>

            <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="save()">Simpan
                Perubahan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d',
        width: '100%'
    });

    function save(){
        const form = new FormData($('#form-edit')[0]);
		Swal.fire({
			text: 'apakah anda yakin?',
			showCancelButton: true,
			confirmButtonText: `Yakin`,
			cancelButtonText: `Tidak`,
		}).then( async (result) => {
			if (result.value) {
				try {
					const response = await axios.post('{{route('bidan.pasien.modal.physic.examination.store')}}',form)    
					if(response.data.status!=1){
						Swal.fire({ icon:'warning', text:response.data.msg })
						return
					}
					Swal.fire({ icon:'success', text:'Prubahan disimpan' })
					.then(res=>{ window.top.backButton() })
				} catch (error) {
					Swal.fire({ icon:'warning', text:error })
				}
			}else if (result.dismiss === 'cancel') {
				Swal.fire( 'Batal', 'data batal di simpan', 'error' )
			}		
		})
    }
</script>
@endpush
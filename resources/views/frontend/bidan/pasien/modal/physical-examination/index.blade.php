@extends('frontend.layouts.frame')
@section('content')

<div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
    <div class="container-mhealth pt-2">
        <form id="form-edit">
            @csrf
            <input type="hidden" name="id" value="{{ $physic->id ?? '' }}">
            <input type="hidden" name="pasienid" value="{{ $pasien_id }}">
            <div class="form-group">
                <label for="">Tanggal</label>
                <input type="text" name="date" required readonly
                    class="form-control font-size-16 datepicker form-mhealth" placeholder="Tanggal"
                    value="{{ $physic->date ?? '' }}">
            </div>
            <div class="form-group">
                <label for="">Tinggi Badan</label>
                <input type="number" name="tb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tinggi Badan" value="{{ $physic->tb ?? '' }}">
            </div>
            <div class="form-group">
                <label for="">Berat Badan</label>
                <input type="number" name="bb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Berat Badan" value="{{ $physic->bb ?? '' }}">
            </div>
            <div class="form-group">
                <label for="">Conjuctiva</label>
                <select name="conjuctiva" required class="form-control font-size-16 form-mhealth">
                    <option value="0">Pilih Conjuctiva</option>
                    <option value="pucat" @if ($physic->conjuctiva == 'pucat')
                        {{ 'selected' }}
                        @endif>Pucat</option>
                    <option value="tidak" @if ($physic->conjuctiva == 'tidak')
                        {{ 'selected' }}
                        @endif>Tidak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Skelera</label>
                <select name="skelera" required class="form-control font-size-16 form-mhealth">
                    <option value="0">Pilih Skelera</option>
                    <option value="kuning" @if ($physic->skelera == 'kuning')
                        {{ 'selected' }}
                        @endif>Kuning</option>
                    <option value="tidak" @if ($physic->skelera == 'tidak')
                        {{ 'selected' }}
                        @endif>Tidak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Kelopak Mata</label>
                <input type="text" name="kelopak_mata" required class="form-control font-size-16 form-mhealth"
                    placeholder="Kelopak Mata" value="{{ $physic->kelopak_mata ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Darah HG</label>
                <input type="text" name="darah_hg" required class="form-control font-size-16 form-mhealth"
                    placeholder="Darah HG" value="{{ $physic->darah_hg ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Darah HB</label>
                <input type="text" name="darah_hb" required class="form-control font-size-16 form-mhealth"
                    placeholder="Darah HB" value="{{ $physic->darah_hb ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Suhu</label>
                <input type="text" name="suhu" required class="form-control font-size-16 form-mhealth"
                    placeholder="Suhu" value="{{ $physic->suhu ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Nadi</label>
                <input type="text" name="nadi" required class="form-control font-size-16 form-mhealth"
                    placeholder="Nadi" value="{{ $physic->nadi ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Pernafasan</label>
                <input type="text" name="pernafasan" required class="form-control font-size-16 form-mhealth"
                    placeholder="Pernafasan" value="{{ $physic->pernafasan ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Mulut</label>
                <input type="text" name="mulut" required class="form-control font-size-16 form-mhealth"
                    placeholder="Mulut" value="{{ $physic->mulut ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Telinga</label>
                <input type="text" name="telinga" required class="form-control font-size-16 form-mhealth"
                    placeholder="Telinga" value="{{ $physic->telinga ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Hidung</label>
                <input type="text" name="hidung" required class="form-control font-size-16 form-mhealth"
                    placeholder="Hidung" value="{{ $physic->hidung ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Tenggorokan</label>
                <input type="text" name="tenggorokan" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tenggorokan" value="{{ $physic->tenggorokan ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Tinggi Fundus</label>
                <input type="text" name="tinggi_fundus" required class="form-control font-size-16 form-mhealth"
                    placeholder="Tinggi Fundus" value="{{ $physic->tinggi_fundus ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Ballotement</label>
                <input type="text" name="ballotement" required class="form-control font-size-16 form-mhealth"
                    placeholder="Ballotement" value="{{ $physic->ballotement ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Posisi Janin</label>
                <input type="text" name="posisi_janin" required class="form-control font-size-16 form-mhealth"
                    placeholder="Posisi Janin" value="{{ $physic->posisi_janin ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Pergerakan Janin</label>
                <input type="text" name="pergerakan_janin" required class="form-control font-size-16 form-mhealth"
                    placeholder="Pergerakan Janin" value="{{ $physic->pergerakan_janin ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Denyut Jantung</label>
                <input type="text" name="jantung_denyut" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Jantung" value="{{ $physic->jantung_denyut ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Denyut Frekuensi</label>
                <input type="text" name="jantung_frekuensi" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Frekuensi" value="{{ $physic->jantung_frekuensi ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Denyut Irama</label>
                <input type="text" name="jantung_irama" required class="form-control font-size-16 form-mhealth"
                    placeholder="Denyut Irama" value="{{ $physic->jantung_irama ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Genitalia</label>
                <input type="text" name="genitalia" required class="form-control font-size-16 form-mhealth"
                    placeholder="Genitalia" value="{{ $physic->genitalia ?? '' }}">
            </div>

            <div class="form-group">
                <label for="">Extermitas</label>
                <input type="text" name="extermitas" required class="form-control font-size-16 form-mhealth"
                    placeholder="Extermitas" value="{{ $physic->extermitas ?? '' }}">
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

    async function save(){
        const form = new FormData($('#form-edit')[0]);
        const response = await axios.post('{{route('bidan.pasien.modal.physic.examination.store')}}',form)
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
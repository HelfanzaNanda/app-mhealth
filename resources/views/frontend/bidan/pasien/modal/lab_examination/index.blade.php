@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <input type="hidden" name="id" value="{{ $lab->id ?? '' }}">
                <input type="hidden" name="pasienid" value="{{ $pasien_id }}">
                <div class="form-group">
                    <label for="">Tanggal</label>
                    <input type="text" name="date" required readonly
                    class="form-control font-size-16 datepicker form-mhealth" 
                    placeholder="Tanggal" value="{{ $lab->date ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">hemoglobin</label>
                    <input type="number" name="hemoglobin" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="hemoglobin" value="{{ $lab->hemoglobin ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">Golongan Darah</label>
                    <input type="number" name="golongan_darah" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="Golongan Darah" value="{{ $lab->golongan_darah ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">Protein Urine</label>
                    <input type="number" name="protein_urine" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="Protein Urine" value="{{ $lab->protein_urine ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">Gula Darah</label>
                    <input type="number" name="gula_darah" 
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="Gula Darah" value="{{ $lab->gula_darah ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">Hepatitis B</label>
                    <input type="number" name="hepatitis_b" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="Hepatitis B" value="{{ $lab->hepatitis_b ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">HIV</label>
                    <input type="number" name="hiv" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="HIV" value="{{ $lab->hiv ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">pms</label>
                    <input type="number" name="pms" required
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="pms" value="{{ $lab->pms ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">Lainnya</label>
                    <input type="text" name="lainnya" 
                    class="form-control font-size-16 form-mhealth" 
                    placeholder="Lainnya" value="{{ $lab->lainnya ?? '' }}">
                </div>

                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="save()">Simpan Perubahan</button>
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
        try {
            const response = await axios.post('{{route('bidan.pasien.modal.lab.examination.store')}}',form)    
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

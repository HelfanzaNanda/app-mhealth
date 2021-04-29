@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Abortus</label>
                    <input type="date" name="tanggal" id="tanggal" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Tempat Abortus</label>
                    <input type="text" name="tempat" id="tempat" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Penolong Abortus</label>
                    <input type="text" name="penolong" id="penolong" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Lama Persalinan</label>
                    <input type="text" name="lama" id="lama" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Jenis Persalinan</label>
                    <input type="text" name="jenis" id="jenis" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Usia Kehamilan</label>
                    <input type="number" name="usia" id="usia" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Komplikasi Saat Persalinan</label>
                    <input type="text" name="komplikasi" id="komplikasi" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Kondisi Anak</label>
                    <input type="text" name="kondisi_anak" id="kondisi_anak" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">BB Anak</label>
                    <input type="number" name="bb_anak" id="bb_anak" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Lama Menyusui Ekslusif</label>
                    <input type="number" name="lama_menyusui_ekslusif" id="lama_menyusui_ekslusif" 
                    class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label for="">Kematian Anak</label>
                    <input type="number" name="kematian" id="kematian" 
                    class="form-control font-size-16 form-mhealth">
                </div>

                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="simpan()">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">

        async function simpan(){
            const url = "{{route('pasien.modal.history_prev_pregnancy.store')}}"
            const form = new FormData($('#form-edit')[0]);
            try {
                const response = await axios.post(url,form)
                console.log(response);
                if (response.data.status != 1) {
                    Swal.fire({ icon:'warning', text:res.data.msg })
                    return
                }
                Swal.fire({ icon:'success', text:'Perubahan disimpan' })
                .then( res =>{
                    window.top.backButton()
                })
                
            } catch (error) {
                Swal.fire({ icon:'warning', text:error })
            }    
        }
    </script>
    @endpush
@endsection

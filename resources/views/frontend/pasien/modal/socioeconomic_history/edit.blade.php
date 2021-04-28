@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">Usia Menikah</label>
                    <input type="text" name="usia_menikah" id="usia_menikah" 
                    class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->usia_menikah ?? '' }}">
                </div>
                
                <div class="form-group">
                    <label for="">Perkawinan Ke</label>
                    <input type="number" name="perkawinanke" id="perkawinanke" 
                    class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->perkawinanke ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">Merokok</label>
                    <select name="merokok" id="merokok" class="form-control font-size-16 form-mhealth">
                        @if ($data)
                            <option value="0"{{ $data->merokok == 0 ? 'selected' : '' }}>Tidak Meorokok</option>
                            <option value="1"{{ $data->merokok == 1 ? 'selected' : '' }}>Merokok</option>    
                        @else
                            <option value="0">Tidak Meorokok</option>
                            <option value="1">Merokok</option>    
                        @endif
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Alkohol</label>
                    <select name="alkohol" id="alkohol" class="form-control font-size-16 form-mhealth">
                        @if ($data)
                            <option value="0"{{ $data->alkohol == 0 ? 'selected' : '' }}>Tidak Alkohol</option>
                            <option value="1"{{ $data->alkohol == 1 ? 'selected' : '' }}>Alkohol</option>
                        @else
                        <option value="0">Tidak Alkohol</option>
                        <option value="1">Alkohol</option>
                        @endif
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Narkoba</label>
                    <select name="narkoba" id="narkoba" class="form-control font-size-16 form-mhealth">
                        @if ($data)
                        <option value="0"{{ $data->narkoba == 0 ? 'selected' : '' }}>Tidak Narkoba</option>
                        <option value="1"{{ $data->narkoba == 1 ? 'selected' : '' }}>Narkoba</option>
                        @else
                        <option value="0">Tidak Narkoba</option>
                        <option value="1">Narkoba</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="">HIV</label>
                    <select name="hiv" id="hiv" class="form-control font-size-16 form-mhealth">
                        @if ($data)
                        <option value="0"{{ $data->hiv == 0 ? 'selected' : '' }}>Tidak HIV</option>
                        <option value="1"{{ $data->hiv == 1 ? 'selected' : '' }}>HIV</option>
                        @else
                        <option value="0">Tidak HIV</option>
                        <option value="1">HIV</option>
                        @endif
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pencegahan Malaria</label>
                    <select name="pencegahan_malaria" id="pencegahan_malaria" class="form-control font-size-16 form-mhealth">
                        @if ($data)
                        <option value="0"{{ $data->pencegahan_malaria == 0 ? 'selected' : '' }}>Tidak Pencegahan</option>
                        <option value="1"{{ $data->pencegahan_malaria == 1 ? 'selected' : '' }}>Pencegahan</option>
                        @else
                        <option value="0">Tidak Pencegahan</option>
                        <option value="1">Pencegahan</option>
                        @endif
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Riwayat Imunisasi</label>
                    <input type="text" name="riwayat_imunisasi" id="riwayat_imunisasi" 
                    class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->riwayat_imunisasi ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">Riwayat Penyakit</label>
                    <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" 
                    class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->riwayat_penyakit ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="">Gerakan Janin</label>
                    <input type="text" name="gerakan_janin" id="gerakan_janin" 
                    class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->gerakan_janin ?? '' }}">
                </div>
                
                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="simpan()">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        async function simpan(){
            const id = "{{ $data->id ?? '' }}"
            const url = "{{route('pasien.profile.modal.socioeconomic_history.update', '')}}"+"/"+id
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

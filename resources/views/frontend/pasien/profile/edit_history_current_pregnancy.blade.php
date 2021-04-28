@extends('frontend.layouts.frame')
@section('content')

    <div class="pb-3 bg-grey mt-1" style="max-height: 100vh; overflow: auto">
        <div class="container-mhealth pt-2">
            <form id="form-edit">
                @csrf
                <div class="form-group">
                    <label for="">Kehamilan</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth"
                    value="{{ $data->kehamilan }}">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Terakhir Haid</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth" 
                    value="{{ $data->tanggal_haid_terakhir }}">
                </div>
                <div class="form-group">
                    <label for="">HPL</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth"
                    value="{{ $data->hpl }}">
                </div>
                <div class="form-group">
                    <label for="">Usia Kehamilan</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth"
                    value="{{ $data->usia_kehamilan }}">
                </div>
                <div class="form-group">
                    <label for="">Siklus Haid</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth"
                    value="{{ $data->siklus_haid }}">
                </div>
                <div class="form-group">
                    <label for="">Pendarahan</label>
                    <input type="text" readonly class="form-control font-size-16 form-mhealth"
                    value="{{ $data->pendarahan ? 'ada' : 'tidak ada' }}">
                </div>

                <div class="form-group">
                    <label for="">Keputihan</label>
                    <select name="keputihan" id="keputihan" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="0" {{ $data->keputihan ? 'selected' : '' }}>Tidak Ada</option>
                        <option value="1" {{ $data->keputihan ? 'selected' : '' }}>Ada</option>
                    </select>
                </div>
                <div class="keputihan_warna">
                    @if ($data->keputihan)
                        <div class="form-group">
                            <label for="">Keputihan Warna</label>
                            <input type="text" name="keputihan_warna" id="keputihan_warna" 
                            class="form-control font-size-16 form-mhealth">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Keputihan Gatal</label>
                    <select name="keputihan_gatal" id="keputihan-gatal" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="0"{{ $data->keputihan_gatal ? 'selected' : '' }}>Tidak Gatal</option>
                        <option value="1"{{ $data->keputihan_gatal ? 'selected' : '' }}>Gatal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Mual</label>
                    <select name="mual" id="mual" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="tidak mual" {{ $data->mual == 'tidak mual' ? 'selected' : '' }}>Tidak Mual</option>
                        <option value="mual" {{ $data->mual == 'mual' ? 'selected' : '' }}>Mual</option>
                        <option value="kadang-kadang" {{ $data->mual == 'kadang-kadang' ? 'selected' : '' }}>Kadang-Kadang</option>
                        <option value="sering" {{ $data->mual == 'sering' ? 'selected' : '' }}>Sering</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Pemakaian Obat</label>
                    <select name="pemakaian_obat" id="pemakaian_obat" class="form-control font-size-16 form-mhealth" style="height: 51px !important">
                        <option value="0"{{ $data->pemakaian_obat ? 'selected' : '' }}>Tidak Pakai</option>
                        <option value="1"{{ $data->pemakaian_obat ? 'selected' : '' }}>Pakai</option>
                    </select>
                </div>
                <div class="jenis_obat">
                    @if ($data->pemakaian_obat)
                        <div class="form-group">
                            <label for="">Jenis Obat</label>
                            <input type="text" name="jenis_obat" id="jenis_obat" 
                            class="form-control font-size-16 form-mhealth">
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="">Keluhan Lainnya (opsional)</label>
                    <input type="text" name="keluhan_lainnya" id="keluhan_lainnya" 
                    class="form-control font-size-16 form-mhealth" placeholder="keluhan Lainnya">
                </div>

                
                <button class="btn btn-block btn-mhealth btn-pink text-white mt-3" type="button" onclick="simpan()">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">

        $(document).on('change', '#keputihan', function (e) { 
            const value = $(this).find('option:selected').val();
            const label = 'Keputihan Warna'
            const name = 'keputihan_warna'
            if (value == 1) {
                $('.keputihan_warna').html(showInput(label, name))
            }else{
                $('.keputihan_warna').empty()
            }
        })

        $(document).on('change', '#pemakaian_obat', function (e) { 
            const value = $(this).find('option:selected').val();
            const label = 'Jenis Obat'
            const name = 'jenis_obat'
            if (value == 1) {
                $('.jenis_obat').html(showInput(label, name))
            }else{
                $('.jenis_obat').empty()
            }
        })

        function showInput(label, name) { 
            let input = ''
                input += '<div class="form-group">'
                input += '    <label for="">'+label+'</label>'
                input += '    <input type="text" name="'+name+'" id="'+name+'" '
                input += '    class="form-control font-size-16 form-mhealth">'
                input += '</div>'
            return  input
        }

        async function simpan(){
            const id = "{{ $data->id }}"
            const url = "{{route('pasien.profile.modal.history_current_pregnancy.change', '')}}"+"/"+id
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
                    window.location.href = "{{ route('pasien.profile.index') }}"
                })
                
            } catch (error) {
                Swal.fire({ icon:'warning', text:error })
            }    
        }
    </script>
    @endpush
@endsection

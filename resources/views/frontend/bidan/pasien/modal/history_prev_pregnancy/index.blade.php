@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="min-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        @forelse ($datas as $key => $data)
        <div class="card box-shadow mb-2 card-{{ $key }}">
            <div class="card-body">
                <div class="row align-items-center ">
                    <div class="col-1">{{ $loop->iteration }}.</div>
                    <div class="col-9">
                        <p>{{ $data->tanggal }}</p>
                        <p>Penolong : {{ $data->penolong }}</p>
                        <p>Tempat : {{ $data->tempat }}</p>
                        <p>Persalinan : {{ $data->lama }}</p>
                    </div>
                    <div class="col-1">
                        <button data-key="{{ $key }}" data-id="{{ $data->id }}" class="btn btn-danger btn-remove-item btn-sm"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div> 
        @empty
        <div class="card box-shadow mb-2">
            <div class="card-body">
                <div class="row align-items-center justify-content-center">
                    <h4 class="text-pink-active">Tidak Ada Data</h4>
                </div>
            </div>
        </div>
        @endforelse
        
    </div>
</div>
@endsection

@push('scripts')
    <script>

        $(document).on('click', '.btn-remove-item', async function (e) {  
            e.preventDefault()
            const id = $(this).data('id')
            const key = $(this).data('key')
            const url = "{{route('pasien.modal.history_prev_pregnancy.delete', '')}}"+"/"+id
            try {
                const response = await axios.delete(url)
                console.log(response);
                if (response.data.status != 1) {
                    Swal.fire({ icon:'warning', text:res.data.msg })
                    return
                }
                
                Swal.fire({ icon:'success', text:'Perubahan disimpan' })
                .then( res =>{
                    $('.card-'+key).remove()    
                })
            } catch (error) {
                Swal.fire({ icon:'warning', text:error })
            }  
        })
    </script>
@endpush
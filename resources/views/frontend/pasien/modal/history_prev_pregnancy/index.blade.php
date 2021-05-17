@extends('frontend.layouts.frame')
@section('content')

<div class="bg-grey pt-3 pb-60" style="min-height: 100vh; overflow: auto">
    <div class="container-mhealth">
        @foreach ($datas as $key => $data)
        <div class="card box-shadow rounded mb-2 card-{{ $key }}">
            <div class="card-body">
				<div>
					<small>Penolong</small>
					<p>{{ $data->penolong }}</p>
				</div>
				<div>
					<small>Tempat</small>
					<p>{{ $data->tempat }}</p>
				</div>
				<div>
					<small>Persalinan</small>
					<p>{{ $data->lama }}</p>
				</div>
				<hr>
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<small>{{ $data->tanggal->diffForHumans() }}</small>
					</div>
					<div>
						<button data-key="{{ $key }}" data-id="{{ $data->id }}" class="btn btn-danger btn-remove-item btn-sm"><i class="fas fa-trash"></i></button>
					</div>
				</div>
                {{-- <div class="row align-items-center ">
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
                </div> --}}
            </div>
        </div>
        @endforeach
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
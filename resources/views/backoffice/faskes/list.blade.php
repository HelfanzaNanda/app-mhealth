@extends('backoffice.layout.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush
@section('content')
<div id="content">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h5 class="mb-0">Fasilitas Kesehatan</h5>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">

          <a class="btn btn-sm btn-primary mb-2 mb-md-0" href="{{ route('backoffice.faskes.insert') }}">
            <i class="fa fa-plus"></i>
            Add
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="mb-2">
        <div class="table-responsive py-1" style="min-height: 50vh">
          @include('backoffice.components.datatable-default',[
          'url'=>route('backoffice.faskes.datatables'),
          'columns'=>[
          'nama'=>'<th>Nama</th>',
          'alamat'=>'<th>Alamat</th>',
          'nohp'=>'<th>No Hp</th>',
          'email'=>'<th>Email</th>',
          'kelurahan'=>'<th>Kelurahan</th>',
          'kecamatan'=>'<th>Kecamatan</th>',
          'kabupaten'=>'<th>Kabupaten</th>',
          '_buttons'=>'<th></th>'
          ],
          ])
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  async function Delete(id) {
    const url = '{{ route('backoffice.faskes.delete', '') }}' + '/' + id;
    Swal.fire({
        title: 'Are you sure ?',
        text: "You won't be able to revert this !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result) {
          axios.delete(url)
            .then(res=> {
                if(res.data.status!=1){
                    Swal.fire({
                        icon:'warning',
                        text:res.data.msg
                    })
                    return
                }
                Swal.fire({
                    icon:'success',
                    text:'Perubahan disimpan'
                }).then(res=>{
                    $('#datatable').DataTable().ajax.reload()
                })
            }).catch(error=>{
                Swal.fire({
                    icon:'warning',
                    text:error
                })
            })
        }
    })
  }
</script>
@endpush
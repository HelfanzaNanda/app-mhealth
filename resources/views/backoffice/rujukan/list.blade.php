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
          <h5 class="mb-0">Rujukan</h5>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="mb-2">
        <div class="table-responsive py-1" style="min-height: 50vh">
          @include('backoffice.components.datatable-default',[
          'url'=>route('backoffice.rujukan.datatables'),
          'columns'=>[
          'bidan'=>'<th>Bidan</th>',
          'pasien'=>'<th>Pasien</th>',
          'faskes'=>'<th>Faskes</th>',
          'tanggal_rujukan'=>'<th>Tanggal Rujukan</th>',
          'download_surat_rujukan'=>'<th>Surat Rujukan</th>',
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

</script>
@endpush
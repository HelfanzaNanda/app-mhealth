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
          <h5 class="mb-0">Kategori</h5>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">

          <a class="btn btn-sm btn-primary mb-2 mb-md-0" href="{{route('backoffice.kategori.insert')}}">
            <i class="fa fa-plus"></i>
            Add
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="mb-2">
        <div class="table-responsive py-1" style="min-height: 50vh">
          @include('backoffice.components.datatable-default', [
          'url'=>route('backoffice.kategori.datatables'),
          'columns'=>[
          'kategori'=>'<th>Kategori</th>',
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
  function Delete(x) {
  }
</script>
@endpush
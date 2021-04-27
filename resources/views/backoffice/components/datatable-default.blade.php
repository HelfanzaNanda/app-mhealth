<table class="table table-hover table-bordered table-sm" id="datatable">
  <thead>
    <tr class="font-weight-bold">
      <th style="width: 1%"></th>
      @foreach($columns as $column=>$th)
      {!! $th !!}
      @endforeach
    </tr>
    <tr>
      <th></th>
      @foreach($columns as $column=>$th)
      @if($column[0]!='_')
      <th>
        <input type="text" class="form-control form-control-sm" placeholder="Filter" >
      </th>
      @else
      <th></th>
      @endif
      @endforeach
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            "orderCellsTop": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ $url }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
              {
                data:'_',
                render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
                }
              },
              @foreach($columns as $column=>$title)
                { "data": "{{$column}}" },
              @endforeach
            ]  
        });
        $("#datatable thead tr:eq(1) th").each(function(i){
          $( 'input, select', this ).on( 'keyup change', function () {
            console.log(i);
            if ( table.column(i).search() !== this.value ) {
                  table
                      .column(i)
                      .search( this.value )
                      .draw();
              }
          });
        })
    });
</script>
@endpush
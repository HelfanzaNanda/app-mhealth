@extends('frontend.layouts.app')
@section('content')
    <div class="container box-shadow" style="height: 60px">
        <div class="hadow shadow-lg">
            <div class="justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500 text-center">Ibu Hamil</div>
            </div>
        </div>
    </div>


    <div class="floating-action text-white text-center" onclick="openFrame('{{route('bidan.pasien.modal.insert')}}','Daftarkan Ibu Hamil')">
        <img src="{{ asset('images/icon/floating-add.png') }}" width="26" height="26">
        <i class="fas fa-plus w-100 h-50 fa-lg my-auto"></i>
    </div>

    <div class="pt-23" style="max-height: 86vh; overflow: auto">
        <div class="container-mhealth ">
            <div class="form-group has-warning has-feedback">
                <div class="input-group-mhealth">
                    <span class="form-control-feedback-left">
                        <img src="{{ asset('images/icon/search.png') }}" width="22" height="22">
                    </span>
                    <input type="text" class="form-control 
                     pl-5 font-18px form-mhealth" 
                    placeholder="Cari Ibu Hamil">
                </div>
            </div>
            <div style="flex-grow: 1;overflow: auto;" id="pasien">
            </div>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        function loadItems(){
            var key = Math.ceil(Math.random()*1000);
            axios.post('{{route('bidan.pasien.load_items')}}',{filter:$('#filter').val(),key:key})
            .then(res=>{
                if(res.data.status==1){
                    if(res.data.key==key){
                        $('#pasien').html(res.data.result);
                    }
                }
            })
        }
        $(document).ready(()=>{
          loadItems();  
        })
    </script>
    @endpush
@endsection

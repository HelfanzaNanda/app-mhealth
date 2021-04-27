@extends('frontend.layouts.app')
@section('content')
    <div class="container box-shadow" style="height: 60px">
        <div class="hadow shadow-lg">
            <div class="justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500 text-center">Pendidikan Kesehatan</div>
            </div>
        </div>
    </div>

    <div class="pt-23" style="height: 86vh; overflow: auto">
        <div class="container-mhealth ">
            <div class="form-group has-warning has-feedback">
                <div class="input-group-mhealth">
                    <span class="form-control-feedback-left">
                        <img src="{{ asset('images/icon/search.png') }}" width="22" height="22">
                    </span>
                    <input type="text" class="form-control 
                     pl-5 font-18px form-mhealth" id="filter"
                    placeholder="Cari Artikel" oninput="loadItems()">
                </div>
            </div>
          
            <ul class="nav justify-content-start flex-nowrap " style="overflow-x: auto;">
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink active" data-toggle="tab" href="#cat-all">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink" data-toggle="tab" href="#cat-recommended">Rekomendasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink" data-toggle="tab" href="#cat-pregnant">Kehamilan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink" data-toggle="tab" href="#cat-test">Test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink" data-toggle="tab" href="#cat-health">kesehatan</a>
                </li>
            </ul>
            <hr>
            <div class="tab-content">
                <div class="tab-pane active" id="cat-all" >
                    
                </div>
                <div class="tab-pane fade" id="cat-recommended" >
                    
                </div>
                <div class="tab-pane fade" id="cat-pregnant" >
                    
                </div>
                <div class="tab-pane fade" id="cat-test" >
                    
                </div>
                <div class="tab-pane fade" id="cat-health" >

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        function loadItems(){
            var key = Math.ceil(Math.random()*1000);
            axios.post('{{route('pasien.health_education.load_items')}}',{filter:$('#filter').val(),key:key})
            .then(res=>{
                if(res.data.status==1){
                    if(res.data.key==key){
                        for(i in res.data.result){
                            // console.log(res.data.result[i]);
                            $('#cat-'+i).html(res.data.result[i]);
                        }
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

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
                     pl-5 font-18px form-mhealth" id="search"
                    placeholder="Cari Artikel" oninput="loadItems()">
                </div>
            </div>
          
            <ul class="nav justify-content-start flex-nowrap " style="overflow-x: auto;">
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink active" 
                    onclick="loadItems()"
                    >Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-light-pink" 
                    onclick="loadItems(true)" >Recommended</a>
                </li>
                @foreach ($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link text-nowrap text-light-pink" 
                        onclick="loadItems(false, '{{ $category->id }}')" >{{ $category->kategori }}</a>
                    </li>
                @endforeach
            </ul>
            <hr>
            <div id="content"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">

    $(document).ready(function () {  
        loadItems()
    })

    async function loadItems(recommended = false, category = null) {  
        const search = $('#search').val()
        try {
            const response = await axios.post('{{route('pasien.health_education.load_items')}}',{
                search:search,
                recommended:recommended,
                category:category
            })
            if (response.status == 200) {
                $('#content').html(showItems(response.data))
            }
        } catch (error) {
            console.log(error);
        }
    }


    function showItems(items) {
        let layout = ''
        $.each(items, function(index, item){
            layout += '<div class="d-flex" onclick="gotoDetail('+item.id+')">'
            layout += '    <div class="mr-19 h-94 w-94 d-inline-block">'
            layout += '        <img src=" {{ URL::asset('') }}'+item.cover+'" class="rounded-4" width="94" height="94" style="object-fit: cover; object-position: center">'
            layout += '    </div>'
            layout += '    <div class="w-251 ">'
            layout += '        <div class="text-pink "></div>'
            layout += '        <div class="font-weight-500 line-height-23 font-18px "> '+item.title+' </div>'
            layout += '        <div class=" font-14" style="color: #BBBBBB">'+new Date(item.date).toISOString().split('T')[0]+'</div>'
            layout += '    </div>'
            layout += '</div>'
            layout += '<hr>'
        });
        return layout
    }

    function gotoDetail(id){
        openFrame('{{ route("pasien.health_education.modal.detail", "") }}/'+id+'','',{fullscreen:true,light:true})
    }
</script>
@endpush

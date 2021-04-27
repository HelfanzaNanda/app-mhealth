@foreach($items as $item)
<div class="d-flex" onclick="openFrame('{{route('pasien.health_education.modal.detail')}}','',{fullscreen:true,light:true})">
    <div class="mr-19 h-94 w-94 d-inline-block">
        <img src="https://akcdn.detik.net.id/visual/2019/09/18/fef8eda8-9c35-4d7d-ad09-058ba2b8d032_169.jpeg?w=650" class="rounded-4" width="94" height="94">
    </div>
    <div class="w-251 ">
        <div class="text-pink "></div>
        <div class="font-weight-500 line-height-23 font-18px ">
            {{$item->title}}
        </div>
        <div class=" font-14" style="color: #BBBBBB">{{date('d M Y, H:i',strtotime($item->date))}}</div>
    </div>
</div>
<hr>
@endforeach
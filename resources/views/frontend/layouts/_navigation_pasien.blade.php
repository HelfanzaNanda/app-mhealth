<div class="bottom-nav" 
    style="
        padding: 10px 0;
        z-index: 999;
        box-shadow: 0 1px 5px 1px rgba(238, 238, 238, 0.5), 0
        1px 5px 0 rgb(235, 235, 235);;
    ">
    @if($__userdata->role=='pasien')
    <div class="d-flex justify-content-around">
        <a href="{{route('pasien.home')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/home.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-active-pink p-0 m-0">Home</p>
        </a>
        <a href="{{route('pasien.health_education.index')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/forme.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Untuk Anda</p>
        </a>
        <a href="{{route('pasien.profile.index')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/profil.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Profile</p>
        </a>

        <a href="{{route('logout')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/profil.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Keluar</p>
        </a>
    </div>
    @elseif($__userdata->role=='bidan')
    <div class="d-flex justify-content-around">
        <a href="{{route('bidan.home')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/home.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Home</p>
        </a>
        <a href="{{route('bidan.pasien.index')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/pasien.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Pasien</p>
        </a>
        <a href="{{route('bidan.visit.index')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/visit.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Kunjungan</p>
        </a>
        <a href="{{route('bidan.home')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/report.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Laporan</p>
        </a>
        <a href="{{route('bidan.profile.index')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/profil.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Profile</p>
        </a>

        <a href="{{route('logout')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/profil.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Keluar</p>
        </a>
    </div>
    @endif
  </div>

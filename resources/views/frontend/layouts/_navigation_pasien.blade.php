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

            @if (request()->is('pasien'))
            <img src="{{ asset('images/icon/pasien/active/home-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Home</p>
            @else
            <img src="{{ asset('images/icon/pasien/normal/home.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Home</p>
            @endif
            
        </a>
        <a href="{{route('pasien.health_education.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('pasien/health_education'))
            <img src="{{ asset('images/icon/pasien/active/pendidikan-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Untuk Anda</p>
            @else
            <img src="{{ asset('images/icon/pasien/normal/pendidikan.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Untuk Anda</p>
            @endif
        </a>
        <a href="{{route('pasien.profile.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('pasien/profile'))
            <img src="{{ asset('images/icon/pasien/active/profil-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Profile</p>
            @else
            <img src="{{ asset('images/icon/pasien/normal/profil.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Profile</p>
            @endif
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
            @if (request()->is('bidan'))
            <img src="{{ asset('images/icon/bidan/active/home-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Home</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/home.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Home</p>
            @endif
        </a>
        <a href="{{route('bidan.pasien.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('bidan/pasien'))
            <img src="{{ asset('images/icon/bidan/active/pasien-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Pasien</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/pasien.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Pasien</p>
            @endif
        </a>
        <a href="{{route('bidan.visit.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('bidan/visit'))
            <img src="{{ asset('images/icon/bidan/active/kunjungan-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Kunjungan</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/kunjungan.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Kunjungan</p>
            @endif
        </a>
        <a href="{{route('bidan.rujukan.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('bidan/rujukan'))
            <img src="{{ asset('images/icon/bidan/active/kunjungan-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Rujukan</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/kunjungan.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Rujukan</p>
            @endif
        </a>
        <a href="{{route('bidan.home')}}" class="text-center p-0 m-0" >
            @if (request()->is('bidan/laporan'))
            <img src="{{ asset('images/icon/bidan/active/laporan-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Laporan</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/laporan.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Laporan</p>
            @endif
        </a>
        <a href="{{route('bidan.profile.index')}}" class="text-center p-0 m-0" >
            @if (request()->is('bidan/profile'))
            <img src="{{ asset('images/icon/bidan/active/profil-active.png') }}" alt="">  
            <p class="font-xs text-active-pink p-0 m-0">Profile</p>
            @else
            <img src="{{ asset('images/icon/bidan/normal/profil.png') }}" alt="">      
            <p class="font-xs text-light-pink p-0 m-0">Profile</p>
            @endif
        </a>

        <a href="{{route('logout')}}" class="text-center p-0 m-0" >
            <img src="{{ asset('images/icon/profil.png') }}" alt="">
            {{-- <i class="fas fa-home h-40 text-active-pink p-0 m-0"></i> --}}
            <p class="font-xs text-light-pink p-0 m-0">Keluar</p>
        </a>
    </div>
    @endif
  </div>

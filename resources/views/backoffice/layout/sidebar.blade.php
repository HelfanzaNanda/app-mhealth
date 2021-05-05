<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      <img src="{{asset('assets/images/logo-main.png')}}" style="width: 80%">
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('backoffice/') }}" class="nav-link">
          <i class="link-icon" data-feather="activity"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['rujukan']) }}">
        <a href="{{ url('backoffice/rujukan') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Rujukan</span>
        </a>
      </li>

      <li class="nav-item {{ active_class(['users']) }}">
        <a href="{{ url('backoffice/users') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Kunjungan</span>
        </a>
      </li>


      <li class="nav-item {{ active_class(['users']) }}">
        <a href="{{ url('backoffice/kategori') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Kategori</span>
        </a>
      </li>

      <li class="nav-item {{ active_class(['users']) }}">
        <a href="{{ url('backoffice/promosi-kesehatan') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Promosi Kesehatan</span>
        </a>
      </li>

      <li class="nav-item {{ active_class(['users']) }}">
        <a href="{{ url('backoffice/users') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Users</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['pasien']) }}">
        <a href="{{ url('backoffice/pasien') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Ibu Hamil</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['bidan']) }}">
        <a href="{{ url('backoffice/bidan') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Bidan</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['faskes']) }}">
        <a href="{{ url('backoffice/faskes') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Faskes</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['faskes']) }}">
        <a href="{{ url('backoffice/notifikasi') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Notifikasi</span>
        </a>
      </li>

    </ul>
  </div>
</nav>
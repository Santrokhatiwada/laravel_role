<header class="header header-sticky mb-4">
    <div class="container-fluid">
      <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <svg class="icon icon-lg">
          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
        </svg>
      </button><a class="header-brand d-md-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="{{asset('')}}coreui/assets/brand/coreui.svg#full"></use>
        </svg></a>
      <ul class="header-nav d-none d-md-flex">
        <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        
      </ul>
      <ul class="header-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
            </svg></a></li>
      </ul>
      <ul class="header-nav ms-3">
        <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-md">{{ Auth::user()->name }} </div>
          </a>
          
          <div class="dropdown-menu dropdown-menu-end pt-0">
    <div class="dropdown-header bg-light py-2">
        <div class="fw-semibold">{{ auth()->user()->nameP }}</div>
    </div>
    <div class="text-center my-3">
        <a class="btn btn-info" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();">
            Logout
        </a>
    </div>
    <form id="logout" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</div>

        </li>
      </ul>
    </div>

  
    <div class="header-divider"></div>
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
          <li class="breadcrumb-item">
            <!-- if breadcrumb is single--><span>Home</span>
          </li>
          <li class="breadcrumb-item active"><span>Dashboard</span></li>
        </ol>
      </nav>
    </div>
  </header>

 
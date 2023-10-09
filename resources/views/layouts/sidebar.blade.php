<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
  <div class="sidebar-brand d-none d-md-flex">

    <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
      <use xlink:href="{{asset('')}}coreui/assets/brand/coreui.svg#signet"></use>
    </svg>
  </div>
  <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">
        <svg class="nav-icon">
          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
        </svg> Dashboard</a></li>

    <!-- <ul class="sidebar-nav" data-coreui="navigation" data-simplebar=""> -->
    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">


        @if(Auth::user()->hasRole('Admin') || Auth::user()->is_super == 1)
    <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
    <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a></li>
    <li><a class="nav-link" href="{{ route('products.index') }}">Manage Product</a></li>
    <li><a class="nav-link" href="{{ route('activity') }}">Activity</a></li>

    <li><a class="nav-link" href="{{ route('projects.index') }}">Project Management</a></li>
    <li><a class="nav-link" href="{{ route('tasks.index') }}">Task Management</a></li>
    @endif

    @role('User')
    <li><a class="nav-link" href="{{ route('users.index')}}">My Profile</a></li>
    @endrole

    @role('User')
    <li><a class="nav-link" href="{{ route('tasks.index') }}">My Task</a></li>
    @endrole








  </ul>

</div>
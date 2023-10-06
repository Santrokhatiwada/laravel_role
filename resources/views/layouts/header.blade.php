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
        <script src="{{ asset('js/script.js') }}"></script>


       
<!-- Notification Icon with Shake Animation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">








    <!-- Notification Icon with Shake Animation and Dropdown -->
<li class="nav-item dropdown">
    <a onclick="setNotificationCount()" class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
       
        <i class="fa-regular fa-bell" id="notificationIcon" style="font-size: 24px; color: red;"><span id="notification_count" style="font-size:1rem; margin-left:.2rem; position:absolute;top:-0px;">1</span></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end" id="notificationDropdown">
        <!-- Your notification list goes here -->
        <div class="dropdown-header">Notifications</div>
        <!-- Add individual notifications in a loop or with dynamic data -->
       
        <!-- Add more notifications as needed -->
    </div>
</li>

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

  
  </header>

  <!-- ... your existing HTML code ... -->

<!-- JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Your JavaScript code -->
<script>
  function setNotificationCount(){
    document.getElementById('notification_count').innerText='';
  }
  getNotification();
function getNotification() {
    // Perform an AJAX request to fetch notifications
  
    $.ajax({
        url: '/notifications', // Replace with the actual route to retrieve notifications
        type: 'GET',
        headers:{
          'X-CSRF-TOKEN': "{{ csrf_token()}}"
        },
        success: function(data) {
            // Assuming notifications have 'id' and 'message' fields
            var notificationDropdown = $('#notificationDropdown');
            // Clear existing dropdown items
            notificationDropdown.empty();
            // Populate the dropdown with notification items
            console.log(data.length);
            data.forEach(function(notification) {
                    var item = $('<a>').addClass('dropdown-item').attr('href', '#').text(notification.data);
                    notificationDropdown.append(item);
                    document.getElementById('notification_count').innerText=data.length;
                });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
};
</script>


 
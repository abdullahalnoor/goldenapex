<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top" style="background: #ffffff">
  <ul class="navbar-nav mr-auto middle-nav-link">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();" >
       <i class="icon-menu menu-icon" style="color: black"></i>
     </a>
    </li><span style="margin-left: 180px;"></span>

  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">


    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="{{ asset('admin') }}/assets/images/user.png" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="{{ asset('admin') }}/assets/images/user.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-2 user-title"><?php echo Auth::guard('employee')->user()->name ?></h6>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
        <li class="dropdown-divider"></li>
        <li> <a class="dropdown-item" href="{{ route('employee.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="icon-power mr-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('employee.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>
</header>
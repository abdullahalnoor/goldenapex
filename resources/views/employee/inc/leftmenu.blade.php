   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="{{ url('/employee')}}">
       <img src="{{ asset('admin') }}/assets/images/logo.png" class="logo-icon" alt="logo icon">
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
        <li><a href="{{ url('/employee/login')}}" class="waves-effect">
          <i class="icon-home"></i> <span>Employee Dashboard</span> <i class=""></i>
        </a></li>

      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-money"></i>
          <span>Marketing</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
        <li><a href="{{ url('/employee/order')}}"><i class="fa fa-circle-o"></i> Order</a></li>
        <li><a href="{{ url('/employee/collection')}}"><i class="fa fa-circle-o"></i> Money Collections</a></li>
        </ul>
      </li>

    </ul>
	 
   </div>
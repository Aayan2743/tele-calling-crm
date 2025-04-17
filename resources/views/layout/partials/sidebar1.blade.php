<!-- Sidebar -->
<div class="sidebar" id="sidebar">
        <div class="modern-profile p-3 pb-0">
				
                <div class="sidebar-nav mb-3">
                        <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent"
                                role="tablist">
                                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                                <li class="nav-item"><a class="nav-link border-0" href="{{url('chat')}}">Chats</a></li>
                                <li class="nav-item"><a class="nav-link border-0" href="{{url('email')}}">Inbox</a></li>
                        </ul>
                </div>
        </div>
        <div class="sidebar-header p-3 pb-0 pt-2">
                
                <div class="d-flex align-items-center justify-content-between menu-item mb-3">
                        <div class="me-3">
                                <a href="{{url('calendar')}}" class="btn btn-icon border btn-menubar">
                                        <i class="ti ti-layout-grid-remove"></i>
                                </a>
                        </div>
                        <div class="me-3">
                                <a href="{{url('chat')}}" class="btn btn-icon border btn-menubar position-relative">
                                        <i class="ti ti-brand-hipchat"></i>
                                </a>
                        </div>
                        <div class="me-3 notification-item">
                                <a href="{{url('activities')}}" class="btn btn-icon border btn-menubar position-relative me-1">
                                        <i class="ti ti-bell"></i>
                                        <span class="notification-status-dot"></span>
                                </a>
                        </div>
                        <div class="me-0">
                                <a href="{{url('email')}}" class="btn btn-icon border btn-menubar">
                                        <i class="ti ti-message"></i>
                                </a>
                        </div>
                </div>
        </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="clinicdropdown">
                    <a href="{{ url('profile') }}">
                        <img src="{{ URL::asset('/build/img/profiles/avatar-14.jpg') }}" class="img-fluid" alt="Profile">
                        <div class="user-names">
                            <h5>Adrian Davies</h5>
                            <h6>Tech Lead</h6>
                        </div>
                    </a>
                </li>
            </ul>
            <ul>
               
                <!-- ssssss -->
                <li>
                    <h6 class="submenu-hdr">Membership</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('membership-plans', 'membership-addons', 'membership-transactions') ? 'subdrop active' : '' }}">
                                <i class="ti ti-file-invoice"></i><span>Membership</span><span
                                    class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a class="{{ Request::is('membership-plans') ? 'active' : '' }}"
                                        href="{{ url('membership-plans') }}">Membership Plans</a></li>
                              
                                <li><a class="{{ Request::is('membership-transactions') ? 'active' : '' }}"
                                        href="{{ url('membership-transactions') }}">Transactions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
              <!-- ssss -->
               
               
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

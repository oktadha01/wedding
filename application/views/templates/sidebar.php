
<div id="left-sidebar" class="sidebar">
    <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-arrow-left"></i></button>
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="<?= base_url('assets'); ?>/images/user.png" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class=" user-name"><strong><?= $this->session->userdata('userdata')->nama; ?></strong></a>
                <!-- <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="page-profile2.html"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                </ul> -->
            </div>
            <hr>
            <!-- <ul class="row list-unstyled">
                <li class="col-3">
                    <small>Sales</small>
                    <h6>561</h6>
                </li>
                <li class="col-3">
                    <small>Order</small>
                    <h6>920</h6>
                </li>
                <li class="col-3">
                    <small>Revenue</small>
                    <h6>$23B</h6>
                </li>
                <li class="col-3">
                    <small>Revenue</small>
                    <h6>$23B</h6>
                </li>
            </ul> -->
        </div>
        <!-- Nav tabs -->
        <!-- <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat"><i class="icon-book-open"></i></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i class="icon-question"></i></a></li>
        </ul> -->

        <!-- Tab panes -->
        <div class="tab-content padding-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu li_animation_delay">
                        <!-- <li class="menu">
                            <a href="<?= site_url('dashboard'); ?>" class=""><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                        </li> -->
                        <li class="menu">
                            <a href="<?= site_url('dashboard'); ?>" class=""><i class="fa fa-dashboard"></i><span>Absensi</span></a>

                        </li>
                        <li class="menu">
                            <a href="<?= site_url('Kehadiran'); ?>" class=""><i class="fa fa-dashboard"></i><span>Kehadiran</span></a>

                        </li>
                        <li class="menu">
                            <a href="<?= site_url('Karyawan'); ?>" class=""><i class="fa fa-dashboard"></i><span>Karyawan</span></a>
                        </li>
                        <li class="menu">
                            <a href="<?= site_url('Izin'); ?>" class=""><i class="fa fa-dashboard"></i><span>Izin</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
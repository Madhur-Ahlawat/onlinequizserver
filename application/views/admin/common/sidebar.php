<?php 
	$setn = array();
	$settinglist = get_setting();

	$get_menus = get_menu();
	foreach ($settinglist as $set) {
		$setn[$set->key] = $set->value;
	}
	$menu = $this->uri->segment(2);

	$menuName = isset($menu) ? $menu : 'dashboard';

?>
<!-- Start wrapper-->
<div id="wrapper">
	<!--Start sidebar-wrapper-->
	<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
		<div class="brand-logo">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url() . 'assets/images/app/' . $setn['app_logo']; ?>" class="logo-icon">
				<h5 class="logo-text"><?php echo $setn['app_name']; ?></h5>
			</a>
		</div>
		<div class="scrollbar" id="style-3" style="height: calc(100vh - 121px);overflow: auto;">
			<ul class="sidebar-menu do-nicescrol">
                <li>
                    <a href="<?php echo base_url(); ?>admin/dashboard" class="waves-effect">
                        <i class="fa fa-dashboard"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>admin/users" class="waves-effect">
                        <i class="fa fa-user"></i><span class="nav-text">User</span>
                    </a>
                </li> 
                <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="icon-pie-chart"></i><span>General</span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>
                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/category"> Category </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/level"> Level </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/questionlevel"> Classification </a></li>
                    </ul>
                </li>
              
                <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="fa fa-user"></i><span> Contest </span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>

                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/contest"> Contest List </a></li>
                         <li><a href="<?php echo base_url(); ?>admin/contestquestion"> Question </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/importcontestquestion"> Question Import </a></li>
                    </ul>
                </li>

                 <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="fa fa-life-saver"></i><span> Pratice </span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>

                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/praticequestion"> Question </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/importpraticequestion"> Import </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/report/praticeleaderboard"> Leaderboard </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="fa fa-question"></i><span> Question </span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>

                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/question"> Questions </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/importquestion"> Import </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/report/leaderboard"> Leaderboard </a></li>
                    </ul>
                </li>
                 <li>
                    <a href="<?php echo base_url(); ?>admin/withdrawal" class="waves-effect">
                        <i class="fa fa-money"></i><span class="nav-text"> Withdrawal </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="fa fa-bell-o"></i><span> Notification </span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>

                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/notification/list"> Notification List </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/notification"> Send Notification </a></li>
                        <li><a href="<?php echo base_url(); ?>admin/notification/setting"> Notification setting </a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>admin/generalsetting" class="waves-effect">
                        <i class="fa fa-wrench"></i><span class="nav-text"> General setting </span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void()" class="waves-effect">
                        <i class="fa fa-gear"></i><span> Settings </span>
                        <i class="fa fa-angle-down float-right"></i>
                    </a>

                    <ul class="sidebar-menu sidebar-submenu ">
                        <li><a href="<?php echo base_url(); ?>admin/setting">Settings</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/setting/adssetting">Ads setting</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/setting/purchase_code">Purchase Code</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>admin/subscription" class="waves-effect">
                        <i class="fa fa-wrench"></i><span class="nav-text"> Packages </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>admin/users/logout" class="waves-effect">
                        <i class="icon-power mr-2"></i><span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
		</div>
	</div>
</div>
<!--End sidebar-wrapper-->

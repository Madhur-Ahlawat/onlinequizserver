<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $setn=array(); 
  $settinglist = get_setting();
  
  foreach($settinglist as $set){
    $setn[$set->key]=$set->value;
  }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title><?php echo $setn['app_name'];?></title>

  <!--favicon-->
  <link rel="icon" href="<?php echo base_url().'assets/images/app/'.$setn['app_logo']; ?>" type="image/x-icon">

  <link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-datepicker/jquery.datetimepicker.min.css">

  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="<?php echo base_url();?>assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="<?php echo base_url();?>assets/css/app-style.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/toastr.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/plugins/summernote/dist/summernote-bs3.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/plugins/summernote/dist/summernote.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet" type="text/css" />

</head> 
<?php
  $this->load->view('admin/common/sidebar');
?>

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top bg-white">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
    
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="<?php echo base_url().'assets/images/no_user.jpg';?>" class="logo-icon" ></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right animated fadeIn">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"></div>
            <div class="media-body">
            <h6 class="mt-2 user-title"><?php echo $this->session->userdata('admin_name');?></h6>
            <p class="user-subtitle"><?php echo $this->session->userdata('admin_email');?></p>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item">
          <a href="<?php echo base_url();?>admin/setting" >
            <i class="icon-settings mr-2"></i> Setting</li>
          </a>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a href="<?php echo base_url();?>admin/users/logout"> <i class="icon-power mr-2"></i>Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

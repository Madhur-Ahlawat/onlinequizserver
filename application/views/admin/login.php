<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
  
  $setn=array(); 
  $settinglist = get_setting();
  
  foreach($settinglist as $set){
    $setn[$set->key]=$set->value;
  }


  $isInsert = isInsert();
  $email = "";
  $password = "";
  if($isInsert == 1)
  {
  	$email = "admin@gmail.com";
  	$password = "12345";
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
  <title><?php echo $setn['app_name']?></title>
  <!--favicon-->
  <link rel="icon" href="<?php echo base_url().'assets/images/app/'.$setn['app_logo']; ?>" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="<?php echo base_url();?>assets/css/app-style.css" rel="stylesheet"/>
  	<link href="<?php echo base_url() ?>assets/css/toastr.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">
 <!-- Start wrapper-->
 <div id="wrapper">
	<div class="card card-authentication1 mx-auto my-5 animated zoomIn bg-skype">
		<div class="card-body">
		 <div class="card-content p-2">
		  <div class="text-center">
		 		<img height="50" width="50" src="<?php echo base_url().'assets/images/app/'.$setn['app_logo']; ?>"/>
		 	</div>
		  <div class="card-title text-uppercase text-center py-2 text-white">Sign In</div>
		    <form class="color-form" id="loginAjax">
			  <div class="form-group">
			   <div class="position-relative has-icon-left">
				  <label for="exampleInputUsername" class="sr-only">Username</label>
				  <input type="email" name="email" id="email" class="form-control" placeholder="email address" value="<?php echo $email;?>">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			   <div class="position-relative has-icon-left">
				  <label for="exampleInputPassword" class="sr-only">Password</label>
				  <input type="password" id="password" name="password" id="exampleInputPassword" class="form-control" placeholder="Password"
				  value="<?php echo $password;?>">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
			<div class="form-row mr-0 ml-0">
			 <div class="form-group col-6">
			   <div class="demo-checkbox">
                <input type="checkbox" name="remember_me" id="remember_me" class="filled-in chk-col-danger" checked="" />
                <label for="remember_me">Remember me</label>
			  </div>
			 </div>
			 <div class="form-group col-6 text-right">
			  <!-- <a href="authentication-dark-reset-password.html">Reset Password</a> -->
			 </div>
			</div>
			
			 <div class="form-group">
			   <button type="button" onclick="login_ajax()" class="btn btn-danger btn-block waves-effect waves-light">Sign In</button>
			 </div>
			 
			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  <!-- waves effect js -->
  <script src="<?php echo base_url();?>assets/js/waves.js"></script>
  <!-- Custom scripts -->
  <script src="<?php echo base_url();?>assets/js/app-script.js"></script>
  	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>

	<script type="text/javascript">
		function login_ajax(){
			var email = $("#email").val();
			var password = $("#password").val();
			if(email == '') {
				toastr.error('Please enter email address.');
				$("#email").focus();
				return false;
			} else if(!validateEmail($("#email").val())) {
				toastr.error('Please enter valid email address');
				$("#email").focus();
				return false;
			} else if(password == '') {
				toastr.error('Please enter password.');
				$("#password").focus();
				return false;
			} else {
				if($("#remember_me").is(":checked"))
				{
					var remember_me = 1;
				}
				else{
					var remember_me = 0;
				}
				var dataString = "email=" + email + "&password=" + password + "&remember_me=" + remember_me;

				$.ajax({
					type: 'post',
					url: '<?php echo base_url() ?>login/login_admin',
					data: dataString,
					success: function (data) {
						var obj = JSON.parse(data);
						console.log(data.status);
						if(obj.status == '200') {
                        	window.location.replace("<?php echo base_url() ?>admin/dashboard");
						}else{
							toastr.error(obj.message);
						}
					},
				   	 error: function (xhr, ajaxOptions, thrownError) {
				        console.log(xhr);
				    }
				});
			}
			event.preventDefault();
			return false;
}	
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
</script>
</body>

</html>


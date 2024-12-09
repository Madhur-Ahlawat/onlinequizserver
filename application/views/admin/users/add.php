<?php
	$this->load->view('admin/common/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-1 pb-1">
			<div class="col-sm-9">
				<h4 class="page-title">Add users</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/users">users</a></li>
					<li class="breadcrumb-item active" aria-current="page">Add users</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>admin/users" class="btn btn-outline-primary waves-effect waves-light">users List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Add User
							<form id="users_form"  enctype="multipart/form-data">
								<div class="row col-lg-12">
									
									<div class="form-group col-lg-4">
										<label for="input-1">Name</label>
										<input type="text" required value="" class="form-control" name="fullname">
									</div>
									<div class="form-group col-lg-4">
			                        	<label for="input-1">User Name</label>
			                        	<input type="text" required value="" class="form-control" name="username">
			                        </div>

									<div class="form-group col-lg-4">
										<label for="input-1">Mobile Number</label>
										<input type="Number" required value="" class="form-control" name="mobile_number"  >
									</div>
								</div>
								<div class="row col-lg-12">
									<div class="form-group col-lg-6">
										<label for="input-1">Email</label>
										<input type="text" required value="" class="form-control" name="email">
									</div>
									<div class="form-group col-lg-6">
										<label for="input-1">Password</label>
										<input type="Password" required value="" class="form-control" name="password" >
									</div>		
								</div>
								<div class="row col-lg-12">
									<div class="form-group col-lg-6">
	                            		<label for="fullname">Instagram URL</label>
										<input type="text" required value="" class="form-control" name="instagram_url"  >
									</div>
									<div class="form-group col-lg-6">
	                            		<label for="fullname">Facebook URL</label>
										<input type="text" required value="" class="form-control" name="facebook_url" >
									</div>
									<div class="form-group col-lg-6">
	                            		<label for="fullname">Twitter URL</label>
										<input type="text" required value="" class="form-control" name="twitter_url">
									</div>
									<div class="form-group col-lg-6">
	                            		<label for="fullname"><?php echo $this->lang->line('BIO_DATA');?></label>
										<input type="text" required value="" class="form-control" name="biodata" id="biodata" >
									</div>
								</div>

								<div class="form-group">
									<button type="button" onclick="saveusers()" class="btn btn-primary shadow-primary px-5">Save</button>&nbsp;&nbsp;
									<a href="<?php echo base_url();?>admin/users"  class="border-primary btn btn-default px-5 "> <?php echo $this->lang->line('cancel');?> </a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

			<?php
			$this->load->view('admin/common/footer');
			?>
			<script type="text/javascript">

				function saveusers(){

					$("#dvloader").show();
					var formData = new FormData($("#users_form")[0]);
					$.ajax({
						type:'POST',
						url:'<?php echo base_url(); ?>admin/users/save',
						data:formData,
						cache:false,
						contentType: false,
						processData: false,
						dataType: "json",
						success:function(resp){
							hideLoader();
							if(resp.status=='200'){
								document.getElementById("users_form").reset();
								toastr.success(resp.msg);
								window.location.replace('<?php echo base_url(); ?>admin/users');
							}else{
								var obj = resp.msg;
								 if (typeof obj === 'string') 
								{
									toastr.error(obj);
								}
								else
								{
									$.each(obj, function(i,e) {
								        toastr.error(e);
								    });
							    }
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							$("#dvloader").hide();
							toastr.error(errorThrown.msg,'failed');         
						}
					});
				}
			</script>
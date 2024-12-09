<?php $this->load->view('admin/common/header');?> 

<div class="clearfix"></div>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Import Questions</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD');?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Import Questions</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>admin/question" class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('LIST_QUESTION');?></a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb--> 

		<div class="row">
			<div class="col-lg-12 ">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Import Questions upload using CSV file</div>
						<hr>
						<form id="question_form"  enctype="multipart/form-data">
							
							<div class="form-group row">
							    <label for="staticEmail" class="col-sm-2 col-form-label"> CSV Questions file </label>
							    <div class="col-sm-6">
								    <input type="file" name="question" class="form-control" id="input-2" onchange="readURL(this,'showImage')">
									<p class="noteMsg"></p>
								</div>
							</div>

							<div class="form-group row">
								<label  class="col-sm-2 col-form-label"> &nbsp;</label>
								 <div class="col-sm-6">
									<button type="button" onclick="savequestion()" class="btn btn-primary upload_csv   px-1">Upload CSV File</button> 

									
									&nbsp;&nbsp;
									
									<a target="_blank" href="<?php echo base_url();?>admin/importquestion/download"  class="border-warning btn btn-warning"><i class="fa fa-download"> Download Sample File Here</i> </a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">

	function savequestion(){
		
		$("#dvloader").show();
		var formData = new FormData($("#question_form")[0]);
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>admin/importquestion/save',
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType: 'json', 
			success:function(resp){
				$("#dvloader").hide();
		
				document.getElementById("question_form").reset();
				if(resp.status=='200'){
					document.getElementById("question_form").reset();
					toastr.success(resp.message);
					setTimeout(function () {
						window.location.replace('<?php echo base_url(); ?>admin/importquestion');
					}, 500);
				}else{
					var obj = resp.message;
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
			}
		});
	}
</script>
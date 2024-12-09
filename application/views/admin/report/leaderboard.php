<?php 
	$this->load->view('admin/common/header');
	$type = isset($_GET['type']) ? $_GET['type'] : 'all';	
?> 

<div class="clearfix"></div>
<div class="content-wrapper">
	<div class="container-fluid">
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Quiz Leaderboard</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quiz Leaderboard </li>
				</ol>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-header"> 
					<div class="custom-radios">
						<form>
							<div class="form-group col-xs-6">
								<label>Search : </label>
							</div>
							<div class="form-group col-xs-6">
								<select name="type" class="form-control col-sm-12 author_id">
									<option value=""> Select Type </option>
									<option value="today" <?php if($type == 'today'){ echo 'selected';}?>>  Today </option>
									<option value="month" <?php if($type == 'month'){ echo 'selected';}?>> Month </option>
									<option value="all" <?php if($type == 'all'){ echo 'selected';}?>>  All </option>
								</select>
							</div>							
							
							<div class="form-group col-xs-6">
								<button class="btn submit"> Search </button>
							</div>
						</form>
					</div>
				</div>

				<div class="card-body">
					<div class="">
						<table id="transaction-datatable" class="table-sm table-striped table-bordered" width="100%">
                            <thead class="badge-secondary ">
                                <tr>
									<th style="height: 40px;"> Image </th>
									<th> Name </th>
									<th> Score </th>
									<th> Rank </th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $key => $value) { ?>
								<tr>
									<td align="center"> <img width="50" src="<?php echo $value['profile_img']?>"></td>
									<td align="center"> <?php echo $value['name'];?></td>
									<td align="center"> <?php echo $value['score'];?></td>
									<td align="center"> <?php echo $value['rank'];?></td>
									
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div><!-- End Row-->
	<?php $this->load->view('admin/common/footer'); ?>
	<script>
		$(document).ready(function(){  
		    $('#transaction-datatable').DataTable();  
			
			$(".start_date").datepicker();
		    $(".end_date").datepicker();  
		});

	</script>
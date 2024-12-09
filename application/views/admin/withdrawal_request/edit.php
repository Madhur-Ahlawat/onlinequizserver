<?php
  $this->load->view('admin/common/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Update Status</h4>
        <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
         <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/Withdrawal">Withdrawal Request</a></li>          
         <li class="breadcrumb-item active" aria-current="page">Update Status</li>
       </ol>
     </div>
  </div>

  <div class="row">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
        <div class="card">
         <div class="card-body">
          <div class="card-title">User Information</div>
          <hr>
         
           <div class="form-group">
            <label for="input-1">FullName : <?PHP echo $userinfo['first_name'].' '.$userinfo['last_name'];?></label>
          </div>

          <div class="form-group">
            <label for="input-1"> Mobile : <?PHP echo $userinfo['mobile_number'];?></label>
          </div>
          <hr>
         <div class="card-title"> Request Information </div>

          <div class="form-group">
            <label for="input-1">Point : <?PHP echo $withdrawal_request['point'];?></label>
          </div>

          <div class="form-group">
            <label for="input-1">Total Amount : <?PHP echo $withdrawal_request['total_amount'];?></label>
          </div>

         <div class="form-group">
            <label for="input-1">Date : <?PHP echo date('d-M-Y h:i A', strtotime($withdrawal_request['created_at']));?></label>
          </div>

          <div class="form-group">
            <label for="input-1">Payment type  :
              <?php 
                if($withdrawal_request['payment_type'] == 1){
                  echo 'Paypal';
                } elseif ($withdrawal_request['payment_type'] == 2) {
                  echo 'paytm';
                }else
                {
                  echo 'Bank Detail';
                }
              ?>
            </label>
          </div>

          <div class="form-group">
            <label> Payment Detail : <?PHP echo $withdrawal_request['payment_detail'];?></label>
          </div>
          <div class="form-group">
            <label>Status : <?php  if($withdrawal_request['status'] == 0) { echo 'Pending';}else{ echo 'Completed';} ?></label>
          </div>
       
          <input type="hidden" id="id" name="id" value="<?PHP echo $withdrawal_request['id'];?>">
            <div class="form-group">
              
              <select name="status" id="status" class="form-control col-lg-3">
                <option value=""> Select Status</option>
                <option value="0" <?php   if($withdrawal_request['status'] == 0) { echo 'selected';}?>> Pending</option>
                <option value="1"  <?php   if($withdrawal_request['status'] ==  1) { echo 'selected';}?>> completed</option>
              </select>
             </div>
           
      </div>
    </div>
  </div></div>
</div></div></div>
</div>

<?php
$this->load->view('admin/common/footer');
?>
<script type="text/javascript">
    $('#status').on('change',function(){
      var status = $(this).val();
      var id = $('#id').val();
      $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>admin/Withdrawal/update',
        data:{'id':id,'status':status},
        dataType: "json",
        success:function(resp){
          if(resp.status=='200'){
              window.location.replace('<?php echo base_url(); ?>admin/Withdrawal');
          }
        }
      });
    })


</script>
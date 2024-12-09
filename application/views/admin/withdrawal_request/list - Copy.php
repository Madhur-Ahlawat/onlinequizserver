<?php $this->load->view('admin/common/header');?>
<!-- usersList Data Show -->
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Withdrawal Request</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Withdrawal Request</li>
        </ol>
      </div>
   
    </div>
    <!-- End Breadcrumb-->
     <div class="">
        <div class="">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Withdrawal Request </div>
                <div class="card-body">
                    <div class="">
                         <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                <thead class="badge-secondary ">
                                <tr>
                                <th>Id</th>
                                <th> Name </th>
                                <th>Point</th>
                                <th>amount</th>
                                <th>Type</th>
                                <th>Detail</th>
                                <th>Date</th>
                                <th >Action</th>
                                </tr>
                              </thead>
                              <tbody>
                  <?php  $i=1; foreach($withdrawal_request as $row){ ?>
                    <tr>
                      <td align="center"><?php echo $i;?></td>
                      <td align="center">
                        <?php 

                          echo string_cut($row['first_name'].' '.$row['last_name'], 10);
                          
                        ?>
                      </td>
                      <td align="center"> <?php echo $row['point']; ?></td>
                      <td align="center"><?php echo $row['total_amount']; ?></td>
                    
                      <td align="center">
                        <?php 
                          if(strlen($row['payment_type']) > 10)
                          {
                            echo '<p title="'.$row['payment_type'].'"> '. substr($row['payment_type'], 0, 10).' ...</p>';
                          }
                          else
                          {
                            echo $row['payment_type'];
                          }
                        ?>
                       </td>
                       <td><?php echo $row['payment_detail'];?></td>
                      <td align="center"><?php echo  date('Y-m-d',strtotime($row['created_at'])); ?></td>
                      
                      <td align="center" width="100" style="width: 20%">
                          <select name="status" class="form-control" onchange="OnSelectChange(this.value,'<?php echo $row['id']?>')" id="status" >
                            <option value=""> Select Status</option>
                            <option value="0" <?php   if($row['status'] == 0) { echo 'selected';}?>> Pending</option>
                            <option value="1"  <?php   if($row['status'] ==  1) { echo 'selected';}?>> Completed</option>
                          </select>
                      </td>
                    </tr>
                    <?php $i++;} ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/common/footer'); ?>
    <script type="text/javascript">

      $(document).ready(function(){
            $('#default-datatable').DataTable( {});
      });
      function OnSelectChange(status,id){
        if(status){
          $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>admin/Withdrawal/update',
            data:{'id':id,'status':status},
            dataType: "json",
            success:function(resp){
              if(resp.status=='200'){
                toastr.success('Status Update Successfully');
              }
            }
          });
        }
      }
     
      </script>
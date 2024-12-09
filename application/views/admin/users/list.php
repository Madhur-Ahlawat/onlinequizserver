<?php $this->load->view('admin/common/header');?>
<!-- usersList Data Show -->
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">users List</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">users List</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="<?php echo base_url();?>admin/users/add" class="btn btn-outline-primary waves-effect waves-light">Add users</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
     <div class="">
        <div class="">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Users </div>
                <div class="card-body">
                    <div class="">
                        <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                            <thead class="badge-secondary ">
                                <tr>
                                  <th style="height: 40px;">Id</th>
                                  <th width="300">Image</th>
                                  <th width="300">FullName</th>
                                  <th width="200">Email</th>
                                  <th width="200">Mobile</th>
                                  <th width="200">Referal Code</th>
                                  <th width="200">Type</th>
                                  <th>Date</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                               $i=1; foreach($userslist as $row){ ?>
                                <tr>
                                  <td align="center"><?php echo $i;?></td>
                                  <td align="center"><img src="<?php echo get_image_path($row->profile_img, 'users'); ?>"  width="50" height="35" /></td>
                                  <td align="center"><?php echo string_cut($row->fullname,14); ?></td>
                                  <td align="center"> <?php echo string_cut($row->email,13); ?></td>
                                  <td align="center"> <?php echo string_cut($row->mobile_number,10);?> </td> 
                                  <td align="center"> <?php echo $row->reference_code;?> </td>

                                  <td align="center"> 
                                    <?php 

                                    if ($row->type == 1) {
                                      echo $type = 'Normal';
                                    } else {
                                      echo $type = 'Social';
                                    }
                                      ?> 
                                  </td>
                                  <td align="center"><?php echo date('Y-m-d',strtotime($row->created_at));?></td>
                                  <td align="center" width="100"><a href="<?php echo base_url()?>admin/users/edit?id=<?php echo $row->id; ?>" title="Edit users" class="btn btn-xs btn-primary p-1" ><i class="fa fa-edit p-1"></i></a> <a href="javaScript:void(0)" title="Delete users" class="btn btn-xs btn-danger p-1" onclick="delete_record('<?php echo $row->id; ?>','users')"><i class="fa fa-trash p-1"></i></a>
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
      <?php
        $this->load->view('admin/common/footer');
      ?>
      <script>
        $(document).ready(function(){
            $('#default-datatable').DataTable({
              responsive: true
            });
        });


        function status_change(id,tablename){
          var status = $('#status_change_'+tablename+id).val();
          if(status=='enable'){
            var status_a='disable';
          }else{var status_a='enable';} 
          swal({
            title: "Are you sure?",
            text: "You want to "+status_a+" "+tablename+"!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes,"+ status_a +" it!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
             $.ajax({
              type:'POST',
              url:'<?php echo base_url(); ?>admin/users/status_change',
              data:{tablename:tablename,id:id,status:status},
              success:function(resp){
                swal( "Your "+tablename+"  has been "+ status_a+ ".", "success");
                jQuery('#'+tablename+id).html(status_a); 
                jQuery('#status_change_'+tablename+id).val(status_a); 

              }
            });
             
           } else {
            swal("Cancelled", "Your "+tablename+" is safe :)", "error");
          }
        });
      }
      </script>
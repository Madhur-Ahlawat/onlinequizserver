<?php
  $this->load->view('admin/common/header');
?>
<style type="text/css">
  .fa-toggle-on{
    color: green;
    font-size: 20px;
  }

  .fa-toggle-off{
    color: red;
    font-size: 20px;
  } 
</style>
<!-- UserList Data Show -->
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Comment</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Comment</li>
        </ol>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered dataTables_font">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th> Users Name </th>
                    <th> Comment </th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i=1; foreach($reviews as $row){ ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td style="width: 10%"><?php  echo string_cut($row->users_name,30); ?></td>
                      <td style="width: 30%">
                        <?php  echo string_cut($row->comment,50); ?>
                      </td>
                      <td><?php echo  dateformate($row->created_at); ?></td>
                    </tr>
                    <?php $i++;} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('admin/common/footer');?>
      <script type="text/javascript">
        $(document).ready(function(){
          $('#default-datatable').DataTable();
        });
      </script>
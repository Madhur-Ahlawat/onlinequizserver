<?php $this->load->view('admin/common/header');?>
<!-- usersList Data Show -->
<div class="clearfix"></div>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Notification</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Notification</li>
        </ol>
      </div>
   
    </div>
    <!-- End Breadcrumb-->
     <div class="">
        <div class="">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Notification List </div>
                <div class="card-body">
                    <div class="">
                         <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                            <thead class="badge-secondary ">
                            <tr>
                            <th> Id </th>
                            <th> Image </th>
                            <th> Title </th>
                            <th> Message </th>
                            <th> Date </th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      <?php $this->load->view('admin/common/footer'); ?>
    <script type="text/javascript">

      $(document).ready(function() {
          var dataTable = $('#default-datatable').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                  url: "<?php echo base_url() . 'admin/notification/fetch_data'; ?>",
                  type: "POST"
              },
              "columnDefs": [{
                  //  "targets":[0, 3, 4],
                  "orderable": false,
              }, ],
          });
      });
      </script>
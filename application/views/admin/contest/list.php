<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('LIST_CONTEST'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('LIST_CONTEST'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/contest/add"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('ADD_CONTEST'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="">
            <div class="">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i>
                        <?php echo $this->lang->line('LIST_CONTEST'); ?> </div>
                    <div class="card-body">
                        <div class="">
                            <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                <thead class="badge-secondary ">
                                    <tr>
                                        <th style="height: 40px;" width="100"><?php echo $this->lang->line('ID'); ?>
                                        </th>
                                        <th>Name</th>
                                        <th width="100">Start Date</th>
                                        <th width="100">End Date</th>
                                        <th width="100">Price</th>
                                        <th width="100">Winner</th>
                                        <th width="100"><?php echo $this->lang->line('ACTION'); ?></th>
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
    </div>
</div>

<?php $this->load->view('admin/common/footer');?>

<script>
$(document).ready(function() {
    var dataTable = $('#default-datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/contest/fetch_data'; ?>",
            type: "POST"
        },
        "columnDefs": [{
            //  "targets":[0, 3, 4],
            "orderable": false,
        }, ],
    });
});
</script>
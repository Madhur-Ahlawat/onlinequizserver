<?php $this->load->view('admin/common/header');?>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css"
    rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css"
    rel="stylesheet" type="text/css">

<div class="clearfix"></div>
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">Classification</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Classification</li>
                    </ol>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <a href="<?php echo base_url(); ?>admin/questionlevel/add"
                            class="btn btn-outline-primary waves-effect waves-light">Add Classification</a>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Classification List
                    </div>
                    <div class="card-body">
                        <div class="">
                            <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                <thead class="badge-secondary ">
                                    <tr>
                                        <th style="height: 40px;">Id</th>
                                        <th><?php echo $this->lang->line('NAME'); ?></th>
                                        <th>Level Order No</th>
                                        <th><?php echo $this->lang->line('ACTION'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;foreach ($level_master as $row) {?>
                                    <tr>
                                        <td align="center"><?php echo $row->id; ?></td>
                                        <td align="center" width="300"><?php echo $row->level_name; ?></td>
                                        <td align="center"><?php echo $row->level_order; ?></td>
                                        <td align="center" width="100">
                                            <a href="<?php echo base_url() ?>admin/questionlevel/edit?id=<?php echo $row->id; ?>"
                                                title="Edit level" class="btn btn-xs btn-primary p-1"><i
                                                    class="fa fa-edit p-1"></i></a>
                                            <a title="Delete level" href="javaScript:void(0)"
                                                onclick="delete_record('<?php echo $row->id; ?>','question_level_master')"
                                                class="btn btn-xs btn-danger p-1"><i class="fa fa-trash p-1"></i></a>
                                        </td>
                                    </tr>
                                    <?php $i++;}?>
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
        $('#default-datatable').DataTable();
    });
</script>
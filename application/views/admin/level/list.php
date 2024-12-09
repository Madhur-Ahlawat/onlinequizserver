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
                <h4 class="page-title"><?php echo $this->lang->line('LIST_LEVEL'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('LIST_LEVEL'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/level/add"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('ADD_LEVEL'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> <?php echo $this->lang->line('LIST_LEVEL'); ?>
                </div>
                <div class="card-body">
                    <div class="">
                        <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                            <thead class="badge-secondary ">
                                <tr>
                                    <th style="height: 40px;">Id</th>
                                    <th><?php echo $this->lang->line('NAME'); ?></th>
                                    <th>Level Order No</th>
                                    <th>Score</th>
                                    <th width="200">Total Question</th>
                                    <th width="200">Next Level Question Count</th>
                                    <th><?php echo $this->lang->line('ACTION'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;foreach ($level as $cat) {?>
                                <tr>
                                    <td align="center"><?php echo $cat->id; ?></td>
                                    <td align="center" width="300"><?php echo $cat->name; ?></td>
                                    <td align="center" width="300"><?php echo $cat->level_order; ?></td>
                                    <td align="center"><?php echo $cat->score; ?></td>
                                    <td align="center"><?php echo $cat->total_question; ?></td>
                                    <td align="center"><?php echo $cat->win_question_count; ?></td>
                                    <td align="center" width="100">
                                        <a href="<?php echo base_url() ?>admin/level/edit?id=<?php echo $cat->id; ?>"
                                            title="Edit level" class="btn btn-xs btn-primary p-1"><i
                                                class="fa fa-edit p-1"></i></a>
                                        <a title="Delete level" href="javaScript:void(0)"
                                            onclick="delete_record('<?php echo $cat->id; ?>','level')"
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
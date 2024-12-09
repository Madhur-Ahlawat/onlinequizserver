<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('LIST_base_setting'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('LIST_base_setting'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/basesetting/add"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('ADD_base_setting'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> <?php echo $this->lang->line('LIST_base_setting'); ?>
                </div>
                <div class="card-body">
                    <div class="">
                        <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                            <thead class="badge-secondary ">
                                <tr>
                                    <th >Id</th>
                                    <th style="height: 40px;" >Key</th>
                                    <th>Value</th>
                                    <th><?php echo $this->lang->line('ACTION'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;foreach ($base_setting as $row) {?>
                                <tr>
                                    <td width="10"><?php echo $i++; ?></td>
                                    <td width="300"><?php echo $row->key; ?></td>
                                    <td width="300"><?php echo $row->value; ?></td>
                                    <td width="100">
                                        <a href="<?php echo base_url() ?>admin/basesetting/edit?id=<?php echo $row->id; ?>"
                                            title="Edit base_setting" class="btn btn-xs btn-primary p-1"><i
                                                class="fa fa-edit p-1"></i></a>
                                        <a title="Delete base_setting" href="javaScript:void(0)"
                                            onclick="delete_record('<?php echo $row->id; ?>','base_setting')"
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
<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('LIST_WINNER'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('LIST_WINNER'); ?></li>
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
                        <?php echo $this->lang->line('LIST_WINNER'); ?> </div>
                    <div class="card-body">
                        <div class="">
                            <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                <thead class="badge-secondary ">
                                    <tr>
                                        <th style="height: 40px;" width="100"><?php echo $this->lang->line('ID'); ?>
                                        </th>
                                        <th width="200">Name</th>
                                        <!--<th width="200">School Name</th>-->
                                        <th width="200">Rank</th>
                                        <th width="200">Score</th>
                                        <th width="200">price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;foreach ($winners as $row) {?>
                                    <tr>
                                        <td align="center"><?php echo $i++; ?></td>
                                        <td width="450"><?php echo $row->user_name; ?></td>
                                        <!--<td width="450"><?php echo $row->school_name; ?></td>-->
                                        <td width="450"><?php echo $row->rank; ?></td>
                                        <td width="450"><?php echo $row->score; ?></td>
                                        <td width="450"><?php echo $row->price; ?></td>

                                    </tr>
                                    <?php }?>
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
    $('#default-datatable').DataTable({});
});
</script>
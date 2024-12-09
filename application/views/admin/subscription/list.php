<?php   $this->load->view('admin/common/header');?>
    <div class="clearfix"></div>
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">Subscription List</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription</li>
                    </ol>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <a href="<?php echo base_url();?>admin/subscription/add" class="btn btn-outline-primary waves-effect waves-light">Add Subscription</a>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-table"></i> Subscription </div>
                        <div class="card-body">
                            <div class="">
                                <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                    <thead class="badge-secondary ">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Coin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;foreach($subscription as $row){ ?>
                                        <tr>
                                            <td> <?php echo $i++; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td ><?php echo $setting['currency'].$row->price; ?></td>
                                            <td> <?php echo $row->coin; ?></td>
                                            <td   width="100">
                                                 <a href="<?php echo base_url()?>admin/subscription/edit?id=<?php echo $row->id; ?>" title="Edit subscription" class="btn btn-xs btn-primary p-1" >
                                                    <i class="fa fa-edit p-1"></i>
                                                </a>
                                                <a href="javaScript:void(0)" title="Delete users" class="btn btn-xs btn-danger p-1" onclick="delete_record('<?php echo $row->id; ?>','plan_subscription')">
                                                    <i class="fa fa-trash p-1"></i>
                                                </a>
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
        </div>
    </div>
<?php $this->load->view('admin/common/footer'); ?>
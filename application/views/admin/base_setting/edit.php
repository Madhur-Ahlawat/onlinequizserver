<?php $this->load->view('admin/common/header');?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('EDIT_base_setting'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/basesetting"><?php echo $this->lang->line('LIST_base_setting'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('EDIT_base_setting'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/basesetting"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('LIST_base_setting'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <?php // print_r($base_setting);?>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><?php echo $this->lang->line('EDIT_base_setting'); ?></div>
                        <hr>
                        <form id="edit_base_setting_form" class="form-horizontal" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?PHP echo $base_setting->id; ?>">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Name </label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $base_setting->key ?>" name="key"
                                        class="form-control" id="pwd" placeholder="Enter key">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> base_setting Order No </label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $base_setting->value ?>" name="value"
                                        class="form-control" placeholder="Enter value">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"> &nbsp;</label>
                                <div class="col-sm-6">
                                    <button type="button" onclick="updatebase_setting()"
                                        class="btn btn-primary  px-5"><?php echo $this->lang->line('update'); ?></button>
                                    &nbsp;&nbsp;
                                    <a href="<?php echo base_url(); ?>admin/basesetting"
                                        class="border-primary btn btn-default px-5 ">
                                        <?php echo $this->lang->line('cancel'); ?> </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/common/footer');?>

<script type="text/javascript">
function updatebase_setting() {
    $("#dvloader").show();
    var formData = new FormData($("#edit_base_setting_form")[0]);
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/basesetting/update',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(resp) {
            $("#dvloader").hide();
            if (resp.status == '200') {
                document.getElementById("edit_base_setting_form").reset();
                toastr.success(resp.message);
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/basesetting');
                }, 500);
            } else {
                toastr.error(resp.message);
            }
        }
    });
}
</script>
<?php $this->load->view('admin/common/header');?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">Notification</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notification setting</li>
            </ol>
        </div>
     </div>
        <div class="clearfix"></div>
        <div class="row">
            <?php $setn = array();foreach ($settinglist as $set) {
                $setn[$set->key] = $set->value;
            }
?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tab panes -->
                        <form id="save_signal_noti" enctype="multipart/form-data">
                            <div class="form-group col-lg-6">
                                <label >OneSignal App ID</label>
                                <input type="text" name="onesignal_apid" required class="form-control"
                                     placeholder="Enter Your App Name"
                                    value="<?php echo $setn['onesignal_apid']; ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label >OneSignal Rest Key</label>
                                <input type="text" name="onesignal_rest_key" required class="form-control"
                                    value="<?php echo $setn['onesignal_rest_key']; ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="input-1">&nbsp;</label>
                                <button type="button" class="btn btn-primary"
                                    onclick="save_signal_noti()"> Save</button>
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
    function save_signal_noti() {
        $("#dvloader").show();
        var formData = new FormData($("#save_signal_noti")[0]);

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>/admin/notification/setting_save',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp) {
                hideLoader();
                toastr.success('Setting saved.');
                window.location.replace('<?php echo base_url(); ?>admin/notification/setting');
            }
        });
    }
</script>
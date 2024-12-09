<?php $this->load->view('admin/common/header');?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">Purchase Code</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Code setting</li>
            </ol>
        </div>
     </div>
        <div class="clearfix"></div>
        <div class="row">
            <?php 
                $setn = array();
                foreach ($settinglist as $set) {
                    $setn[$set->key] = $set->value;
                }

                $check = isInsert();

                if($check == 1){
                    $purchase_code = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
                    $package_name = 'xxxxxxxx';
                }else
                {
                    $purchase_code = $setn['purchase_code'];
                    $package_name = $setn['package_name'];
                }
                
            ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tab panes -->
                        <form id="save_purchase" enctype="multipart/form-data">
                            <div class="row col-lg-12">
                                <div class="form-group col-lg-6">
                                    <label>Purchase Code <a target="_blank"
                                            href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code">
                                            [Where Is My Purchase Code?] </a></label>
                                    <input type="text" name="purchase_code" required class="form-control"
                                        id="purchase_code" value="<?php echo $purchase_code;?>">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label> Package Name </label>
                                    <input type="text" name="package_name" required class="form-control"
                                        id="package_name" value="<?php echo $package_name;?>">
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <button type="button" class="btn btn-primary px-5"
                                    onclick="save_purchase()"> Save</button>
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
    function save_purchase() {
        var formData = new FormData($("#save_purchase")[0]);
        displayLoader();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/setting/save',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(resp) {
                hideLoader();
                if (resp.status == '200') {
                    toastr.success(resp.message, 'Setting saved.');
                    setTimeout(function() {
                        window.location.replace('<?php echo base_url(); ?>admin/setting/purchase_code');
                    }, 500);
                } else {
                    toastr.error(resp.message);
                }
            }
        });
    }
</script>
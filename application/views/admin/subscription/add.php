<?php $this->load->view('admin/common/header'); ?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-1 pb-1">
            <div class="col-sm-9">
                <h4 class="page-title">Add Subscription</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/subscription">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Subscription</li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/subscription" class="btn btn-outline-primary waves-effect waves-light">Subscription</a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <form id="add_channel_form" onsubmit="saveplan();return false;" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Enter name">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Price</label>
                                        <input name="price" type="number" class="form-control" placeholder="Enter Price">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Type</label>
                                        <input type="text" name="currency_type" value="<?php echo $setting['currency'];?>" class="form-control" readonly>
                                    </div>
                                </div>
                                 <div class="form-row">
                                     <div class="form-group col-md-6">
                                        <label>Coin</label>
                                        <input name="coin" type="number" class="form-control" placeholder="Ex. 1">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Product Package</label>
                                        <input name="product_package" type="text" class="form-control" placeholder="Enter product package">
                                    </div>
                                  
                                </div>
                              
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="input-2"> Image</label>
                                        <input type="file" name="image" class="form-control" id="input-2" onchange="readURL(this, 'categoryImage')" >
                                        <p class="noteMsg">Note: Image Size must be lessthan 2MB.Image Height and Width less than 1000px.</p>
                                        <img id="categoryImage" src="<?php echo base_url() . 'assets/images/placeholder.png'; ?>" height="150" width="150" alt="your image" />
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary shadow-primary px-5">Save</button>
                                <a href="<?php echo base_url() ?>admin/subscription" class="btn btn-default border-info px-5">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
    </div>
    <script type="text/javascript">
        function saveplan() {
            displayLoader();
            var formData = new FormData($("#add_channel_form")[0]);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/subscription/save',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (resp) {
                    hideLoader();
                    //document.getElementById("add_channel_form").reset();
                    toastr.success(resp.msg, 'success');
                    setTimeout(function () {
                        window.location.replace('<?php echo base_url(); ?>admin/subscription');
                    }, 500);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    hideLoader();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
    </script>
    <?php $this->load->view('admin/common/footer'); ?>
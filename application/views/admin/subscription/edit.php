<?php $this->load->view('admin/common/header'); ?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-1 pb-1">
            <div class="col-sm-9">
                <h4 class="page-title">Update Subscription</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/subscription">Subscription</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Subscription</li>
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
                            <form id="add_channel_form" onsubmit="updateplan();return false;" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $subplan['id']; ?>">
                                <div class="form-group">
                                    <label>Plan Name</label>
                                    <input name="name" type="text" class="form-control" placeholder="Enter Plan name"
                                           value="<?php echo $subplan['name']; ?>">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Plan Price</label>
                                        <input name="price" type="number" value="<?php echo $subplan['price']; ?>" class="form-control" placeholder="Plan Price">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Type</label>
                                        <input type="text" name="currency_type" value="<?php echo $setting['currency'];?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Coin</label>
                                        <input name="coin" type="number" value="<?php echo $subplan['coin'];?>" class="form-control" placeholder="Ex. 1">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Product Package</label>
                                        <input name="product_package" value="<?php echo $subplan['product_package'];?>"  type="text" class="form-control" placeholder="Enter product package">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" name="id" value="<?PHP echo $subplan['id']; ?>">
                                        <label for="input-2"> Image</label>
                                        <input type="file" name="image" class="form-control" id="image" onchange="readURL(this, 'categoryDisImage')" >
                                        <input type="hidden" name="subplanimage" value="<?PHP echo $subplan['image']; ?>" >
                                        <p class="noteMsg">Note: Image Size must be lessthan 2MB.Image Height and Width less than 1000px.</p>
                                        <div class="imgageResponsive">
                                            <?php $image_path = get_image_path($subplan['image'], 'subplan'); ?>
                                            <img id="categoryDisImage" src="<?php echo $image_path; ?>" height="auto;" width="150px;">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary shadow-primary px-5">Update</button>
                                <a href="<?php echo base_url() ?>admin/subscription" class="btn btn-default border-info px-5">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function updateplan() {
            displayLoader();
            var formData = new FormData($("#add_channel_form")[0]);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>/admin/subscription/update',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (resp) {
                    get_responce_message(resp, 'add_channel_form', 'subscription');                   
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    hideLoader();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
    </script>
<?php $this->load->view('admin/common/footer'); ?>
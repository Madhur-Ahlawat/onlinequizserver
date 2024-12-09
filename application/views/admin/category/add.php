<?php
$this->load->view('admin/common/header');
?> 

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('ADD_CATEGORY'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/category"><?php echo $this->lang->line('LIST_CATEGORY'); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $this->lang->line('ADD_CATEGORY'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/category" class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('LIST_CATEGORY'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb--> 

        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><?php echo $this->lang->line('ADD_CATEGORY'); ?></div>
                        <hr>
                        <form id="category_form"  enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> <?php echo $this->lang->line('NAME'); ?> </label>
                                <div class="col-sm-6">
                                    <input type="text"  value=""  name="name" class="form-control"  placeholder="<?php echo $this->lang->line('ENTER_CATEGORY'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> <?php echo $this->lang->line('image'); ?> </label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" class="form-control" id="input-2" onchange="readURL(this, 'showImage')">
                                    <p class="noteMsg"><?php echo $this->lang->line('IMAGE_INFO'); ?></p>
                                    <img id="showImage" src="<?php echo base_url() . 'assets/images/placeholder.png'; ?>" height="100px" width="100px"/>
                                </div>
                            </div>	

                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label"> &nbsp;</label>
                                <div class="col-sm-6">
                                    <button type="button" onclick="savecategory()" class="btn btn-primary  px-5"><?php echo $this->lang->line('save'); ?></button> &nbsp;&nbsp;
                                    <a href="<?php echo base_url(); ?>admin/category"  class="border-primary btn btn-default px-5 "><?php echo $this->lang->line('cancel'); ?> </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript">
    function savecategory() {
        $("#dvloader").show();
        var formData = new FormData($("#category_form")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/category/save',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (resp) {
                get_responce_message(resp, 'category_form', 'category');
            }
        });
    }
</script>
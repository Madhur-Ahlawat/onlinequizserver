<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('ADD_CONTEST'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/contest"><?php echo $this->lang->line('LIST_CONTEST'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('ADD_CONTEST'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/contest"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('LIST_CONTEST'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->

        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><?php echo $this->lang->line('ADD_CONTEST'); ?></div>
                        <hr>
                        <form id="contest_form" enctype="multipart/form-data" autocomplete="off">
                           
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Level </label>
                                <div class="col-sm-8">
                                    <select name="level_id" class="form-control">
                                        <option value=""> Select Level</option>
                                        <?php foreach ($level as $key => $value) { ?>
                            <option <?php if ($contest['level_id'] == $value->id) {
                                            echo "selected";
                                        } ?> value="<?php echo $value->id; ?>"> <?php echo $value->name; ?></option>
                            <?php } ?>
                            </select>
                    </div>
                </div>
               

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">
                        <?php echo $this->lang->line('NAME'); ?> </label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" value="<?php echo $contest['name']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> <?php echo $this->lang->line('image'); ?>
                    </label>
                    <div class="col-sm-6">
                        <input type="file" name="image" class="form-control" onchange="readURL(this,'showImage')">
                        <input type="hidden" name="contestimage" value="<?PHP echo $contest['image']; ?>">
                        <p class="noteMsg"><?php echo $this->lang->line('IMAGE_INFO'); ?></p>
                        <div><img id="showImage" src="<?php echo get_image_path($contest['image'], 'contest'); ?>"
                                height="100px;" width="100px;"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Statr Date </label>
                    <div class="col-sm-8">
                        <input type="text" name="start_date" class="form-control start_date" autocomplete="off"
                            value="<?php echo $contest['start_date']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> End Date </label>
                    <div class="col-sm-8">
                        <input type="text" name="end_date" class="form-control end_date"
                            value="<?php echo $contest['end_date']; ?>" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Entry Fee </label>
                    <div class="col-sm-8">
                        <input type="text" name="price" class="form-control" value="<?php echo $contest['price']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> No of user </label>
                    <div class="col-sm-8">
                        <input type="number" name="no_of_user" minlength="1" maxlength="10" class="form-control"
                            value="<?php echo $contest['no_of_user']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> No of user Prize </label>
                    <div class="col-sm-8">
                        <input type="text" name="no_of_user_prize" minlength="1" maxlength="10" class="form-control"
                            value="<?php echo $contest['no_of_user_prize']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Total Prize </label>
                    <div class="col-sm-8">
                        <input type="text" name="total_prize" class="form-control"
                            value="<?php echo $contest['total_prize']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> No of Rank </label>
                    <div class="col-sm-8">
                        <input type="text" name="no_of_rank" minlength="1" maxlength="10" class="form-control"
                            value="<?php echo $contest['no_of_rank']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"> &nbsp;</label>
                <div class="col-sm-6">
                    <input type="hidden" name="id" value="<?php echo $contest['id']; ?>">
                    <button type="button" onclick="savecontest()"
                        class="btn btn-primary  px-5"><?php echo $this->lang->line('save'); ?></button>
                    &nbsp;&nbsp;
                    <a href="<?php echo base_url(); ?>admin/contest"
                        class="border-primary btn btn-default px-5 "><?php echo $this->lang->line('cancel'); ?>
                    </a>
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
$('.start_date').datetimepicker({
    format: 'Y-m-d H:m:s'
});
$('.end_date').datetimepicker({
    format: 'Y-m-d H:m:s'
});


function savecontest() {
    $("#dvloader").show();
    var formData = new FormData($("#contest_form")[0]);
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/contest/update',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(resp) {
            $("#dvloader").hide();
            document.getElementById("contest_form").reset();
            if (resp.status == '200') {
                document.getElementById("contest_form").reset();
                toastr.success(resp.message);
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/contest');
                }, 500);
            } else {
                var obj = resp.message;
                if (typeof obj === 'string') {
                    toastr.error(obj);
                } else {
                    $.each(obj, function(i, e) {
                        toastr.error(e);
                    });
                }
            }
        }
    });
}
</script>
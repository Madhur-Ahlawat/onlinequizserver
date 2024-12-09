<?php $this->load->view('admin/common/header'); ?>
<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('EDIT_PRATICE_QUESTION'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/praticequestion"><?php echo $this->lang->line('LIST_PRATICE_QUESTION'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('EDIT_PRATICE_QUESTION'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/praticequestion"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('LIST_PRATICE_QUESTION'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <?php // print_r($question);?>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><?php echo $this->lang->line('EDIT_PRATICE_QUESTION'); ?></div>
                        <hr>
                        <form id="EDIT_PRATICE_QUESTION_form" class="form-horizontal" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $question->id; ?>">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <?php echo $this->lang->line('QUESTION_LEVEL'); ?> </label>
                                <div class="col-sm-8">
                                    <select name="question_level_master_id" class="form-control">
                                        <option value=""> Select Level</option>
                                        <?php foreach ($questionlevel as $key => $value) { ?>
                                        <option <?php if ($question->question_level_master_id == $value->id) {
                                            echo "selected";
                                        } ?> value="<?php echo $value->id; ?>"> <?php echo $value->level_name; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <?php echo $this->lang->line('CATEGORY_NAME'); ?> </label>
                                <div class="col-sm-8">
                                    <select name="category_id" class="form-control">
                                        <option value=""> Select Category</option>
                                        <?php foreach ($category as $key => $value) { ?>
                                        <option <?php if ($question->category_id == $value->id) {
                                            echo "selected";
                                        } ?> value="<?php echo $value->id; ?>"> <?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Question </label>
                                <div class="col-sm-8">
                                    <textarea name="question"
                                        class="form-control"><?php echo $question->question; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <?php echo $this->lang->line('image'); ?> </label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" class="form-control" id="input-2"
                                        onchange="readURL(this, 'showImage')">
                                    <input type="hidden" name="question_image" value="<?PHP echo $question->image; ?>">
                                    <p class="noteMsg"><?php echo $this->lang->line('IMAGE_INFO'); ?></p>
                                    <div><img id="showImage"
                                            src="<?php echo get_image_path($question->image, 'question'); ?>"
                                            height="100px;" width="100px;"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Question Type </label>
                                <div class="col-sm-6">
                                    <span class="border col-3 p-2 ">
                                        <input type="radio" value="1"
                                            <?php if ($question->question_type == 1) { ?>checked="checked"
                                            <?php } ?>name="question_type" class="question_type"> Options
                                    </span>
                                    <span class="border col-3 p-2">
                                        <input type="radio" value="2"
                                            <?php if ($question->question_type == 2) { ?>checked="checked" <?php } ?>
                                            name="question_type" class="question_type"> True / False
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> </label>
                                <div class="col-sm-4">
                                    <label class="form-check-input">A</label> <input type="text"
                                        value="<?php echo $question->option_a; ?>" name="option_a" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-check-input">B</label> <input type="text"
                                        value="<?php echo $question->option_b; ?>" name="option_b" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row option_class">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> </label>
                                <div class="col-sm-4">
                                    <label class="form-check-input">C</label> <input type="text"
                                        value="<?php echo $question->option_c; ?>" name="option_c" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-check-input">D</label> <input type="text"
                                        value="<?php echo $question->option_d; ?>" name="option_d" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Level </label>
                                <div class="col-sm-8">
                                    <select name="level_id" class="form-control">
                                        <option value=""> Select Level</option>
                                        <?php foreach ($level as $key => $value) { ?>
                                        <option <?php if ($question->level_id == $value->id) {
                                            echo "selected";
                                        } ?> value="<?php echo $value->id; ?>"> <?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Answer </label>
                                <div class="col-sm-8">
                                    <select name="answer" class="form-control">
                                        <option value=""> Select Right Answer</option>
                                        <option value="1" <?php if ($question->answer == 1) {
    echo "selected";
} ?>> A </option>
                                        <option value="2" <?php if ($question->answer == 2) {
    echo "selected";
} ?>> B </option>
                                        <option value="3" <?php if ($question->answer == 3) {
    echo "selected";
} ?>> C </option>
                                        <option value="4" <?php if ($question->answer == 4) {
    echo "selected";
} ?>> D </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label"> Note </label>
                                <div class="col-sm-8">
                                    <textarea name="note" class="form-control"><?php echo $question->note; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"> &nbsp;</label>
                                <div class="col-sm-6">
                                    <button type="button" onclick="updatequestion()"
                                        class="btn btn-primary  px-5"><?php echo $this->lang->line('update'); ?></button>
                                    &nbsp;&nbsp;
                                    <a href="<?php echo base_url(); ?>admin/praticequestion"
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

<?php $this->load->view('admin/common/footer'); ?>

<script type="text/javascript">
selecte_type()

function selecte_type() {
    var question_type = $('input[name=question_type]:checked').val()
    if (question_type == 1) {
        $('.option_class').show();
    } else {
        $('.option_class').hide();
    }
}

$('.question_type').on('click', function() {
    var question_type = $('input[name=question_type]:checked').val()

    if (question_type == 1) {
        $('.option_class').show();
    } else {
        $('.option_class').hide();
    }
})


function updatequestion() {
    $("#dvloader").show();
    var formData = new FormData($("#EDIT_PRATICE_QUESTION_form")[0]);
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/praticequestion/update',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(resp) {
            $("#dvloader").hide();
            if (resp.status == '200') {
                document.getElementById("EDIT_PRATICE_QUESTION_form").reset();
                toastr.success(resp.message);
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/praticequestion');
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
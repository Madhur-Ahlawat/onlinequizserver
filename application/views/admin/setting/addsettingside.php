<?php $this->load->view('admin/common/header');?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="clearfix"></div>
        <div class="row">
            <?php 
                $setn = array();
                foreach ($settinglist as $set) 
                {
                    $setn[$set->key] = $set->value;
                }
            ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-pills-danger nav-justified top-icon" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="pill" href="#piil-17"> <span
                                        class="hidden-xs">App</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#piil-20"> <span class="hidden-xs">Change
                                        Password</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#piil-18"> <span
                                        class="hidden-xs">Payment</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#piil-21"> <span
                                        class="hidden-xs">SMTP</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#piil-24"> <span
                                        class="hidden-xs">Currency</span></a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div id="piil-17" class="container tab-pane active show">
                                <form id="save_setting" enctype="multipart/form-data">
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label for="input-1">App Name</label>
                                            <input type="text" name="app_name" required class="form-control"
                                                id="input-1" placeholder="Enter Your App Name"
                                                value="<?php echo $setn['app_name']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Host Email</label>
                                            <input type="text" name="host_email" required class="form-control"
                                                id="input-2" value="<?php echo $setn['host_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label>App Version</label>
                                            <input type="text" name="app_version" required class="form-control"
                                                id="app_version" value="<?php echo $setn['app_version']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label> Author </label>
                                            <input type="text" name="Author" required class="form-control" id="Author"
                                                value="<?php echo $setn['Author']; ?>">
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label> email </label>
                                            <input type="text" name="email" required class="form-control" id="email"
                                                value="<?php echo $setn['email']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-6">
                                            <label> Contact </label>
                                            <input type="text" name="contact" required class="form-control" id="contact"
                                                value="<?php echo $setn['contact']; ?>">
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label>App Descripation</label>
                                            <textarea name="app_desripation" required class="form-control"
                                                id="input-2"><?php echo $setn['app_desripation']; ?></textarea>
                                        </div>
                                       
                                        <div class="form-group  col-lg-12">
                                            <label> Privacy Policy </label> 
                                            <textarea name="privacy_policy" required class="form-control summernote"
                                                id="privacy_policy">
                                                <?php echo $setn['privacy_policy']; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-12">
                                            <label>Instrucation</label>
                                            <textarea name="instrucation" required class="form-control summernote"
                                                id="instrucation"><?php echo $setn['instrucation']; ?></textarea>
                                        </div>

                                    </div>

                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">App Image</label>
                                            <input type="file" name="app_image"
                                                onchange="readURL(this,'showImage',100,200)" required
                                                class="form-control" id="input-2">
                                            <input type="hidden" name="app_image_logo"
                                                value="<?php echo $setn['app_logo']; ?>">
                                            <div>
                                                <p class="noteMsg">Note: Image Size must be lessthan 2MB.Image Height
                                                    and Width Maximum - 100x200</p>
                                                <img id="showImage"
                                                    src="<?php echo base_url() . 'assets/images/app/' . $setn['app_logo']; ?>"
                                                    height="100px" width="100px" />
                                            </div>
                                        </div>
                                        <div class="form-group  col-lg-6">
                                            <label> website </label>
                                            <input type="text" name="website" required class="form-control" id="website"
                                                value="<?php echo $setn['website']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <button type="button" class="btn btn-primary shadow-primary px-5"
                                            onclick="save_setting()"> Save</button>
                                    </div>
                                </form>
                            </div>

                            <div id="piil-18" class="container tab-pane fade">
                                <form id="save_admob" enctype="multipart/form-data">
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Payment Name</label>
                                            <input type="text" name="payment_1" required class="form-control"
                                                id="payment_1" placeholder="Payment 1"
                                                value="<?php echo $setn['payment_1']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-1"></div>
                                        <div class="form-group  col-lg-5">
                                            <div class="form-group row pt-4">
                                                <div class="col-sm-6">
                                                    <span class="border col-3 p-2 ">
                                                        <input type="radio" value="1"
                                                            <?php if ($setn['payment_status_1'] == 1) {?>checked="checked"
                                                            <?php }?> name="payment_status_1" class="payment_status_1">
                                                        Active
                                                    </span>
                                                    <span class="border col-3 p-2">
                                                        <input type="radio" value="0"
                                                            <?php if ($setn['payment_status_1'] == 0) {?>checked="checked"
                                                            <?php }?> name="payment_status_1" class="payment_status_1">
                                                        InActive
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Payment Name</label>
                                            <input type="text" name="payment_2" required class="form-control"
                                                id="payment_2" placeholder="Payment 2"
                                                value="<?php echo $setn['payment_2']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-1"></div>
                                        <div class="form-group  col-lg-5">
                                            <div class="form-group row pt-4">
                                                <div class="col-sm-6">
                                                    <span class="border col-3 p-2 ">
                                                        <input type="radio" value="1"
                                                            <?php if ($setn['payment_status_2'] == 1) {?>checked="checked"
                                                            <?php }?> name="payment_status_2" class="payment_status_2">
                                                        Active
                                                    </span>
                                                    <span class="border col-3 p-2">
                                                        <input type="radio" value="0"
                                                            <?php if ($setn['payment_status_2'] == 0) {?>checked="checked"
                                                            <?php }?> name="payment_status_2" class="payment_status_2">
                                                        InActive
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Payment Name</label>
                                            <input type="text" name="payment_3" required class="form-control"
                                                id="payment_3" placeholder="Payment 3"
                                                value="<?php echo $setn['payment_3']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-1"></div>
                                        <div class="form-group  col-lg-5">
                                            <div class="form-group row pt-4">
                                                <div class="col-sm-6">
                                                    <span class="border col-3 p-2 ">
                                                        <input type="radio" value="1"
                                                            <?php if ($setn['payment_status_3'] == 1) {?>checked="checked"
                                                            <?php }?> name="payment_status_3" class="payment_status_3">
                                                        Active
                                                    </span>
                                                    <span class="border col-3 p-2">
                                                        <input type="radio" value="0"
                                                            <?php if ($setn['payment_status_3'] == 0) {?>checked="checked"
                                                            <?php }?> name="payment_status_3" class="payment_status_3">
                                                        InActive
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Payment Name</label>
                                            <input type="text" name="payment_4" required class="form-control"
                                                id="payment_4" placeholder="Payment 4"
                                                value="<?php echo $setn['payment_4']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-1"></div>
                                        <div class="form-group  col-lg-5">
                                            <div class="form-group row pt-4">
                                                <div class="col-sm-6">
                                                    <span class="border col-3 p-2 ">
                                                        <input type="radio"
                                                            <?php if ($setn['payment_status_4'] == 1) {?>checked="checked"
                                                            <?php }?> value="1" name="payment_status_4"
                                                            class="payment_status_4"> Active
                                                    </span>
                                                    <span class="border col-3 p-2">
                                                        <input type="radio"
                                                            <?php if ($setn['payment_status_4'] == 0) {?>checked="checked"
                                                            <?php }?> value="0" name="payment_status_4"
                                                            class="payment_status_4"> InActive
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Payment Name</label>
                                            <input type="text" name="payment_5" required class="form-control"
                                                id="payment_5" placeholder="Payment 5"
                                                value="<?php echo $setn['payment_5']; ?>">
                                        </div>
                                        <div class="form-group  col-lg-1"></div>
                                        <div class="form-group  col-lg-5">
                                            <div class="form-group row pt-4">
                                                <div class="col-sm-6">
                                                    <span class="border col-3 p-2 ">
                                                        <input type="radio"
                                                            <?php if ($setn['payment_status_5'] == 1) {?>checked="checked"
                                                            <?php }?> value="1" name="payment_status_5"
                                                            class="payment_status_5"> Active
                                                    </span>
                                                    <span class="border col-3 p-2">
                                                        <input type="radio"
                                                            <?php if ($setn['payment_status_5'] == 0) {?>checked="checked"
                                                            <?php }?> value="0" name="payment_status_5"
                                                            class="payment_status_5"> InActive
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <button type="button" class="btn btn-primary shadow-primary px-5"
                                            onclick="save_admob()"> Save</button>
                                    </div>
                                </form>

                            </div>

                            <div id="piil-20" class="container tab-pane fade">
                                <form id="change_passwords" class="mx-auto">
                                    <div class="form-group col-lg-12">
                                        <div class="form-group col-lg-12">
                                            <label for="input-1">Email</label>
                                            <input type="email" name="email" required class="form-control"
                                                id="email" value="<?php echo $this->session->userdata('admin_email'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">

                                        <div class="form-group col-lg-6">
                                            <label for="input-1">New Password</label>
                                            <input type="password" name="password" required class="form-control"
                                                id="password">
                                        </div>
                                        <input type="hidden" name="admin_id"
                                            value="<?php echo $this->session->userdata('admin_id'); ?>">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">Confirm Password</label>
                                            <input type="password" name="confirm_password" required class="form-control"
                                                id="confirm_password" value="">
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <div class="form-group  col-lg-6">
                                        <button type="button" class="btn btn-primary shadow-primary px-5"
                                            onclick="change_passwords()"> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="piil-21" class="container tab-pane fade">
                                <form id="save_smtp_setting" enctype="multipart/form-data">
                                    <div class="row col-lg-12">
                                        <div class="form-group  col-lg-6">
                                            <label for="input-2">IS SMTP Active</label>
                                            <select name="status" class="form-control" id="status">
                                                <option> Select Status</option>
                                                <option value="1"
                                                    <?php if ($smtp_setting['status'] == '1') {echo 'selected="selected"';}?>>
                                                    Yes</option>
                                                <option value="0"
                                                    <?php if ($smtp_setting['status'] == '0') {echo 'selected="selected"';}?>>
                                                    No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">Host</label>
                                            <input type="text" name="host" required class="form-control" id="host"
                                                value="<?php echo $smtp_setting['host']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">Port</label>
                                            <input type="text" name="port" required class="form-control" id="port"
                                                value="<?php echo $smtp_setting['port']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="input-1">Protocol</label>
                                            <input type="text" name="protocol" required class="form-control"
                                                id="protocol" placeholder="Enter Your protocol"
                                                value="<?php echo $smtp_setting['protocol']; ?>">
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">User name</label>
                                            <input type="text" name="user" required class="form-control" id="user"
                                                value="<?php echo $smtp_setting['user']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">Password</label>
                                            <input type="text" name="pass" required class="form-control" id="pass"
                                                value="<?php echo $smtp_setting['pass']; ?>">
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">From name</label>
                                            <input type="text" name="from_name" required class="form-control"
                                                id="from_name" value="<?php echo $smtp_setting['from_name']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="input-2">From Email</label>
                                            <input type="text" name="from_email" required class="form-control"
                                                id="from_email" value="<?php echo $smtp_setting['from_email']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <button type="button" class="btn btn-primary shadow-primary px-5"
                                            onclick="save_smtp_setting()"> Save</button>
                                    </div>
                                </form>
                            </div>

                            <div id="piil-24" class="container tab-pane fade">
                                <form id="save_currency" enctype="multipart/form-data">

                                    <div class="row col-lg-12">
                                        <div class="form-group col-lg-6">
                                            <label>Currency Name </label>
                                            <input type="text" name="currency" required class="form-control"
                                                id="currency" value="<?php echo $setn['currency']; ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label> Currency Code </label>
                                            <input type="text" name="currency_code" required class="form-control"
                                                id="currency_code" value="<?php echo $setn['currency_code']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <button type="button" class="btn btn-primary shadow-primary px-5"
                                            onclick="save_currency()"> Save</button>
                                    </div>
                                </form>
                            </div> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/common/footer');?>
<script type="text/javascript">
function save_setting() {
    $("#dvloader").show();
    var formData = new FormData($("#save_setting")[0]);

    var textareaValue = $('#instrucation').code();
    formData.append("instrucation", textareaValue);

    var privacy_policy = $('#privacy_policy').code();
    formData.append("privacy_policy", privacy_policy);
    

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/setting/save',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            toastr.success('Setting saved.');
            window.location.replace('<?php echo base_url(); ?>admin/setting');
            
        }
    });
}

function save_admob() {
    $("#dvloader").show();
    var formData = new FormData($("#save_admob")[0]);

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>/admin/setting/save',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            toastr.success('Setting saved.');
            window.location.replace('<?php echo base_url(); ?>admin/setting');
        }
    });
}
function save_currency() {
    $("#dvloader").show();
    var formData = new FormData($("#save_currency")[0]);


    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>/admin/setting/save',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            toastr.success('Setting saved.');
            window.location.replace('<?php echo base_url(); ?>admin/setting');
        }
    });
}

function save_signal_noti() {
    $("#dvloader").show();
    var formData = new FormData($("#save_signal_noti")[0]);


    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>/admin/setting/save',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            toastr.success('Setting saved.');
            window.location.replace('<?php echo base_url(); ?>admin/setting');
        }
    });
}

function change_passwords() {
    $("#dvloader").show();
    var formData = new FormData($("#change_passwords")[0]);
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>/admin/setting/change_password',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            var obj = JSON.parse(resp);
            if (obj.status == '200') {
                toastr.success(obj.msg);
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/setting');
                }, 500);
            } else {
                toastr.error(obj.msg);
            }
        }
    });
}

function save_smtp_setting() {
    $("#dvloader").show();
    var formData = new FormData($("#save_smtp_setting")[0]);
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>/admin/setting/save_smtp_setting',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(resp) {
            hideLoader();
            var obj = JSON.parse(resp);
            if (obj.status == '200') {
                toastr.success(obj.msg);
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/setting');
                }, 500);
            } else {
                toastr.error(obj.msg);
            }
        }
    });
}


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
                    window.location.replace('<?php echo base_url(); ?>admin/setting');
                }, 500);
            } else {
                toastr.error(resp.message);
            }
        }
    });
}
</script>
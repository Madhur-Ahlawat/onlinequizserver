<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-1 pb-1">
            <div class="col-sm-9">
                <h4 class="page-title">Settings</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
                </ol>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Settings</h4>
                        <div class="clearfix"></div>
                        <div class="row">
                            <?php
$setn = array();
foreach ($settinglist as $set) {
    $setn[$set->key] = $set->value;
}
?>
                            <div class="col-lg-12">
                                <div>
                                    <div>
                                        <ul class="nav nav-pills nav-pills-danger nav-justified top-icon"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" data-toggle="pill" href="#piil-18">
                                                    <span class="hidden-xs">Admob</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#piil-19"> <span
                                                        class="hidden-xs">Facebook Ads</span></a>
                                            </li>
                                        </ul>

                                        <div class="tab-content card-body">
                                            <div id="piil-18" class="container tab-pane active show">
                                                <ul class="nav nav-tabs nav-tabs-secondary nav-justified top-icon"
                                                    role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" data-toggle="pill"
                                                            href="#admob_1">Android</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#admob_2">IOS</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="admob_1" class="container tab-pane active show">
                                                        <form id="save_admob" enctype="multipart/form-data">
                                                            <div class="row col-lg-12">
                                                                <div class="form-group col-lg-6">
                                                                    <label for="input-1">Publisher ID</label>
                                                                    <input type="text" name="publisher_id" required
                                                                        class="form-control" id="input-1"
                                                                        placeholder="Enter Your App Name"
                                                                        value="<?php echo $setn['publisher_id']; ?>">
                                                                </div>
                                                               <!--  <div class="form-group col-lg-6">
                                                                    <label for="input-1">Interstital AD Click</label>
                                                                    <input type="text" name="interstital_adclick"
                                                                        required class="form-control" id="input-1"
                                                                        placeholder="Enter Your AD Click"
                                                                        value="<?php echo $setn['interstital_adclick']; ?>">
                                                                </div> -->
                                                            </div>
                                                            <div class="row col-lg-12">
                                                                <div class="form-group  col-lg-6">
                                                                    <label for="input-2">Banner Ad</label>
                                                                    <select name="banner_ad" class="form-control"
                                                                        id="banner_ad">
                                                                        <option> Select Banner</option>
                                                                        <option value="yes"
                                                                            <?php if ($setn['banner_ad'] == 'yes') {echo 'selected="selected"';}?>>
                                                                            Yes</option>
                                                                        <option value="no"
                                                                            <?php if ($setn['banner_ad'] == 'no') {echo 'selected="selected"';}?>>
                                                                            No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label for="input-1">Banner Ad ID</label>
                                                                    <input type="text" name="banner_adid" required
                                                                        class="form-control" id="input-1"
                                                                        placeholder="Enter Your App Name"
                                                                        value="<?php echo $setn['banner_adid']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row col-lg-12">

                                                                <div class="form-group col-lg-6">
                                                                    <label for="input-1">Interstital Ad ID</label>
                                                                    <input type="text" name="interstital_adid" required
                                                                        class="form-control" id="input-1"
                                                                        placeholder="Enter Your App Name"
                                                                        value="<?php echo $setn['interstital_adid']; ?>">
                                                                </div>

                                                                <div class="form-group  col-lg-6">
                                                                    <label for="input-2">Interstital Ad</label>
                                                                    <select name="interstital_ad" class="form-control"
                                                                        id="interstital_ad">
                                                                        <option> Select Banner</option>
                                                                        <option value="yes"
                                                                            <?php if ($setn['interstital_ad'] == 'yes') {echo 'selected="selected"';}?>>
                                                                            Yes</option>
                                                                        <option value="no"
                                                                            <?php if ($setn['interstital_ad'] == 'no') {echo 'selected="selected"';}?>>
                                                                            No</option>
                                                                    </select>
                                                                </div>
                                                            </div>



                                                            <div class="row col-lg-12">
                                                                <div class="form-group  col-lg-6">
                                                                    <label for="input-2">Native Ads</label>
                                                                    <select name="native_ad" class="form-control"
                                                                        id="native_ad">
                                                                        <option> Select Banner</option>
                                                                        <option value="yes"
                                                                            <?php if ($setn['native_ad'] == 'yes') {echo 'selected="selected"';}?>>
                                                                            Yes</option>
                                                                        <option value="no"
                                                                            <?php if ($setn['native_ad'] == 'no') {echo 'selected="selected"';}?>>
                                                                            No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label for="input-1">Native Ad ID</label>
                                                                    <input type="text" name="native_adid" required
                                                                        class="form-control" id="input-1"
                                                                        placeholder="Enter Native Ad ID"
                                                                        value="<?php echo $setn['native_adid']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row col-lg-12">

                                                                <div class="form-group  col-lg-6">
                                                                    <label for="input-2">Reward Video Ad</label>
                                                                    <select name="reward_ad" class="form-control"
                                                                        id="reward_ad">
                                                                        <option> Select Banner</option>
                                                                        <option value="yes"
                                                                            <?php if ($setn['reward_ad'] == 'yes') {echo 'selected="selected"';}?>>
                                                                            Yes</option>
                                                                        <option value="no"
                                                                            <?php if ($setn['reward_ad'] == 'no') {echo 'selected="selected"';}?>>
                                                                            No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label for="input-1">Reward Video Ad ID</label>
                                                                    <input type="text" name="reward_adid" required
                                                                        class="form-control"
                                                                        placeholder="Enter Reward Video Ad ID"
                                                                        value="<?php echo $setn['reward_adid']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-lg-12">
                                                                <button type="button"
                                                                    class="btn btn-primary shadow-primary px-5"
                                                                    onclick="save_admob()"> Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="admob_2" class="container tab-pane fade"> Coming Soon
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="piil-19" class="container tab-pane fade">
                                                <form id="save_fbad" enctype="multipart/form-data">
                                                    <div class="row col-lg-12">
                                                        <div class="form-group  col-lg-6">
                                                            <label for="input-2">Native Status</label>
                                                            <select name="fb_native_status" class="form-control"
                                                                id="fb_native_status">
                                                                <option>Native Status</option>
                                                                <option value="on"
                                                                    <?php if ($setn['fb_native_status'] == 'on') {echo 'selected';}?>>
                                                                    ON </option>
                                                                <option value="off"
                                                                    <?php if ($setn['fb_native_status'] == 'off') {echo 'selected';}?>>
                                                                    OFF </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="input-2">Native</label>
                                                            <input type="text" name="fb_native_id" required
                                                                class="form-control" id="input-2"
                                                                value="<?php echo $setn['fb_native_id']; ?>">
                                                        </div>

                                                        <div class="form-group  col-lg-6">
                                                            <label for="input-2">Banner Status</label>
                                                            <select name="fb_banner_status" class="form-control"
                                                                id="fb_banner_status">
                                                                <option>Banner Status</option>
                                                                <option value="on"
                                                                    <?php if ($setn['fb_banner_status'] == 'on') {echo 'selected';}?>>
                                                                    ON </option>
                                                                <option value="off"
                                                                    <?php if ($setn['fb_banner_status'] == 'off') {echo 'selected';}?>>
                                                                    OFF </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="input-2">Banner</label>
                                                            <input type="text" name="fb_banner_id" required
                                                                class="form-control" id="input-2"
                                                                value="<?php echo $setn['fb_banner_id']; ?>">
                                                        </div>

                                                        <div class="form-group  col-lg-6">
                                                            <label for="input-2">Interstiatial Status</label>
                                                            <select name="fb_interstiatial_status" class="form-control"
                                                                id="fb_interstiatial_status">
                                                                <option> Interstiatial Status</option>
                                                                <option value="on"
                                                                    <?php if ($setn['fb_interstiatial_status'] == 'on') {echo 'selected';}?>>
                                                                    ON </option>
                                                                <option value="off"
                                                                    <?php if ($setn['fb_interstiatial_status'] == 'off') {echo 'selected';}?>>
                                                                    OFF </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="input-2">Interstiatial</label>
                                                            <input type="text" name="fb_interstiatial_id" required
                                                                class="form-control" id="input-2"
                                                                value="<?php echo $setn['fb_interstiatial_id']; ?>">
                                                        </div>


                                                        <div class="form-group  col-lg-6">
                                                            <label for="input-2">RewardVideo Status</label>
                                                            <select name="fb_rewardvideo_status" class="form-control"
                                                                id="fb_rewardvideo_status">
                                                                <option> Interstiatial Status</option>
                                                                <option value="on"
                                                                    <?php if ($setn['fb_rewardvideo_status'] == 'on') {echo 'selected';}?>>
                                                                    ON </option>
                                                                <option value="off"
                                                                    <?php if ($setn['fb_rewardvideo_status'] == 'off') {echo 'selected';}?>>
                                                                    OFF </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="input-2">RewardVideo</label>
                                                            <input type="text" name="fb_rewardvideo_id" required
                                                                class="form-control" id="input-2"
                                                                value="<?php echo $setn['fb_rewardvideo_id']; ?>">
                                                        </div>

                                                        <div class="form-group  col-lg-6">
                                                            <label for="input-2">Native Full Status</label>
                                                            <select name="fb_native_full_status" class="form-control"
                                                                id="fb_native_full_status">
                                                                <option> Interstiatial Status</option>
                                                                <option value="on"
                                                                    <?php if ($setn['fb_native_full_status'] == 'on') {echo 'selected';}?>>
                                                                    ON </option>
                                                                <option value="off"
                                                                    <?php if ($setn['fb_native_full_status'] == 'off') {echo 'selected';}?>>
                                                                    OFF </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="input-2">Native Full</label>
                                                            <input type="text" name="fb_native_full_id" required
                                                                class="form-control" id="input-2"
                                                                value="<?php echo $setn['fb_native_full_id']; ?>">
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <button type="button"
                                                            class="btn btn-primary shadow-primary px-5"
                                                            onclick="save_fbad()"> Save </button>
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function save_setting() {
    var formData = new FormData($("#save_setting")[0]);

    var app_desc = $('#app_desc').code();
    formData.append("app_desripation", app_desc);

    var textareaValue = $('#summernote').code();
    formData.append("privacy_policy", textareaValue);

    // displayLoader();
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
                    window.location.replace('<?php echo base_url(); ?>admin/setting/adssetting');
                }, 500);
            } else {
                toastr.error(resp.message);
            }
        }
    });
}

function save_admob() {
    var formData = new FormData($("#save_admob")[0]);
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
                toastr.success(resp.message, 'Password change sucessfully.');
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/setting/adssetting');
                }, 500);
            } else {
                toastr.error(resp.message);
            }
        }
    });
}

function save_fbad() {
    var formData = new FormData($("#save_fbad")[0]);
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
                toastr.success(resp.message, 'Password change sucessfully.');
                setTimeout(function() {
                    window.location.replace('<?php echo base_url(); ?>admin/setting/adssetting');
                }, 500);
            } else {
                toastr.error(resp.message);
            }
        }
    });
}
</script>

<?php $this->load->view('admin/common/footer');?>
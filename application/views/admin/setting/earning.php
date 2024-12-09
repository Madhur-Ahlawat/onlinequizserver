<?php $this->load->view('admin/common/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="clearfix"></div>
        <div class="row">
            <?php
            $setn = array();
            foreach ($settinglist as $set) {
                $setn[$set->key] = $set->value;
            }
            ?>
            <style type="text/css">
                .set_box{
                    padding: 35px;
                }
            </style>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav  nav-tabs-danger nav-justified top-icon" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="pill" href="#admob_1">EARNING SETTING</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#admob_2">SET EARNING POINT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#admob_3">SPIN WHEEL  POINT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#admob_4">DAILY LOGIN POINT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#admob_5">GET FREE CONG POINT</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="admob_1" class="container tab-pane active show">
                                <div class="container tab-pane active show">
                                    <form id="save_setting"  enctype="multipart/form-data">
                                        <div class="row col-lg-12">
                                            <div class=" form-group col-lg-2 same_box">
                                                <label> Point</label>
                                                <input type="number"  name="earning_point" required class="form-control" id="input-2" value="<?php echo $setn['earning_point']; ?>">
                                            </div>
                                            <div class="form-group col-lg-1 set_box same_box">
                                                <label >=</label>
                                            </div>
                                            <div class="form-group col-lg-3 same_box">
                                                <label>Amount</label>
                                                <input type="number" name="earning_amount"  required class="form-control" id="earning_amount" value="<?php echo $setn['earning_amount']; ?>">
                                            </div> 

                                            <div class="form-group col-lg-2">
                                                <label>Currenct</label>
                                                <input type="text" name="currency" class="form-control"  value="<?php echo $setn['currency']; ?>">
                                            </div> 

                                            <div class="form-group col-lg-4 min_earning">
                                                <label> MIN WITHDRAWAL POINTS </label>
                                                <input type="number" name="min_earning_point" required class="form-control" id="min_earning_point" value="<?php echo $setn['min_earning_point']; ?>">
                                            </div>
                                        </div>
                                        <div class="row col-lg-12">
                                            <div class=" form-group col-lg-2 same_box">
                                                <label> Daily Refer Limit</label>
                                                <input type="number"  name="daily_refer_limit" required class="form-control" id="input-2" value="<?php echo $setn['daily_refer_limit']; ?>">
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label for="input-2">wallet withdraw visibility</label>
                                                <select name="wallet_withdraw_visibility" class="form-control"
                                                    id="wallet_withdraw_visibility">
                                                    <option> Select Banner</option>
                                                    <option value="yes"
                                                        <?php if ($setn['wallet_withdraw_visibility'] == 'yes') {echo 'selected="selected"';}?>>
                                                        Yes</option>
                                                    <option value="no"
                                                        <?php if ($setn['wallet_withdraw_visibility'] == 'no') {echo 'selected="selected"';}?>>
                                                        No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <button type="button" class="btn btn-primary shadow-primary px-5" onclick="save_setting()"> Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="admob_2" class="container tab-pane fade"> 
                                <div class="">
                                    <div class="form-group">
                                       <form id="earnpoint_setting"  enctype="multipart/form-data">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="50%"> Activity Name  </th>
                                                        <th> Point</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($earnpoint_setting as $row) { ?>
                                                        <tr>
                                                            <td><?php echo str_replace('_', ' ', ucfirst($row->key)); ?></td>
                                                            <td><input type="number" name="<?php echo $row->key; ?>" required class="form-control" id="<?php echo $row->key; ?>"  value="<?php echo $row->value; ?>"></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <br><br>
                                            <div class="">
                                                <button type="button" class="btn btn-primary shadow-primary px-5" onclick="earnpoint_setting()"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="admob_3" class="container tab-pane fade"> 
                                <div class="">
                                    <div class="form-group">
                                       
                                        <form id="earn_point"  enctype="multipart/form-data">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="50%"> Activity Name  </th>
                                                        <th> Point</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach ($earn_point as $row) { 

                                                        if($row->point_type == 1){?>
                                                        
                                                        <tr>
                                                            <td><?php echo str_replace('_', ' ', ucfirst($row->key)); ?></td>
                                                            <td><input type="number" name="<?php echo $row->key; ?>" required class="form-control" id="<?php echo $row->key; ?>"  value="<?php echo $row->value; ?>"></td>
                                                        </tr>
                                                    <?php } }?>
                                                </tbody>
                                            </table>
                                            <br><br>
                                            <div class="">
                                                <button type="button" class="btn btn-primary shadow-primary px-5" onclick="earn_point()"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="admob_4" class="container tab-pane fade"> 
                                <div class="">
                                    <div class="form-group">
                                        <form id="earn_point-1"  enctype="multipart/form-data">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="50%"> Activity Name  </th>
                                                        <th> Point</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($earn_point as $row) { 

                                                     if($row->point_type == 2){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo str_replace('_', ' ', ucfirst($row->key)); ?></td>
                                                            <td><input type="number" name="<?php echo $row->key; ?>" required class="form-control" id="<?php echo $row->key; ?>"  value="<?php echo $row->value; ?>"></td>
                                                        </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                            <br><br>
                                            <div class="">
                                                <button type="button" class="btn btn-primary shadow-primary px-5" onclick="earn_point1()"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="admob_5" class="container tab-pane fade"> 
                                <div class="">
                                    <div class="form-group">
                                        <form id="earn_point-2"  enctype="multipart/form-data">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="50%"> Activity Name  </th>
                                                        <th> Point</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($earn_point as $row) { 

                                                     if($row->point_type == 3){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo str_replace('_', ' ', ucfirst($row->key)); ?></td>
                                                            <td><input type="number" name="<?php echo $row->key; ?>" required class="form-control" id="<?php echo $row->key; ?>"  value="<?php echo $row->value; ?>"></td>
                                                        </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                            <br><br>
                                            <div class="">
                                                <button type="button" class="btn btn-primary shadow-primary px-5" onclick="earn_point2()"> Save</button>
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
<?php $this->load->view('admin/common/footer'); ?>

<!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap-input-spinner.js"></script> -->

<script type="text/javascript">
    // $("input[type='number']").inputSpinner()

    function save_setting() {
        $("#dvloader").show();

        var formData = new FormData($("#save_setting")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/generalsetting/save',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                hideLoader();
                toastr.success('Setting saved.');
                window.location.replace('<?php echo base_url(); ?>admin/generalsetting');
            }
        });
    }


    function earnpoint_setting()
    {
        $("#dvloader").show();
        var formData = new FormData($("#earnpoint_setting")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/generalsetting/earnpoint_setting',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                hideLoader();
                toastr.success('Earnpoint Setting Saved.');
                window.location.replace('<?php echo base_url(); ?>admin/generalsetting');
            }
        });
    }

    function earn_point()
    {
        $("#dvloader").show();
        var formData = new FormData($("#earn_point")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/generalsetting/earn_point',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                hideLoader();
                toastr.success('Earnpoint Setting Saved.');
                window.location.replace('<?php echo base_url(); ?>admin/generalsetting');
            }
        });
    }

    function earn_point1()
    {
        $("#dvloader").show();
        var formData = new FormData($("#earn_point-1")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/generalsetting/earn_point',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                hideLoader();
                toastr.success('Earnpoint Setting Saved.');
                window.location.replace('<?php echo base_url(); ?>admin/generalsetting');
            }
        });
    }

    function earn_point2()
    {
        $("#dvloader").show();
        var formData = new FormData($("#earn_point-2")[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/generalsetting/earn_point',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                hideLoader();
                toastr.success('Earnpoint Setting Saved.');
                window.location.replace('<?php echo base_url(); ?>admin/generalsetting');
            }
        });
    }

    
</script>

<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->

<!--Start footer-->
<footer class="footer" >
    <div class="container">
        <div class="text-center">
            <?php
            if (strpos(base_url(), 'divinetechs.com')) {
                echo ' Just demo only!!! You have no rights to add,edit or delete.';
            }
            ?>
        </div>
    </div>
</footer>
<!--End footer-->

</div><!--End wrapper-->
<div style="display:none" id="dvloader"><img src="<?php echo base_url(); ?>assets/images/loading.gif" /></div>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.js"></script>

<!-- simplebar js -->
<script src="<?php echo base_url(); ?>assets/plugins/simplebar/js/simplebar.js"></script>
<!-- waves effect js -->
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
<!-- sidebar-menu js -->
<script src="<?php echo base_url(); ?>assets/js/sidebar-menu.js"></script>
<!-- Custom scripts -->
<script src="<?php echo base_url(); ?>assets/js/app-script.js"></script>

<!--<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-datepicker/jquery.datetimepicker.full.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plupload.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/summernote/dist/summernote.min.js"></script>

<script type="text/javascript">
    $('.summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 190,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    function delete_record(id, tablename) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this " + tablename + "!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>admin/common/delete_record',
                            data: {tablename: tablename, id: id},
                            success: function (resp) {
                                swal("Deleted!", "Your " + tablename + "  has been deleted.", "success");

                                setTimeout(function () {
                                    location.reload();
                                }, 1500);

                            }
                        });

                    } else {
                        swal("Cancelled", "Your " + tablename + " is safe :)", "error");
                    }
                });
    }
    function get_responce_message(resp, form_name, url) {
        hideLoader();
        if (resp.status == '200') {
            document.getElementById(form_name).reset();
            toastr.success(resp.message);
            setTimeout(function () {
                window.location.replace('<?php echo base_url(); ?>admin/' + url);
            }, 500);

        } else {
            var obj = resp.message;
            if (typeof obj === 'string') {
                toastr.error(obj);
            } else {
                $.each(obj, function (i, e) {
                    toastr.error(e);
                });
            }
        }
    }
</script>

</body>

</html>

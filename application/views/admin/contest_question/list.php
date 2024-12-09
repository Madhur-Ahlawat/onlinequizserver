<?php $this->load->view('admin/common/header');?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?php echo $this->lang->line('LIST_CONTEST_QUESTION'); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('DASHBOARD'); ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $this->lang->line('LIST_CONTEST_QUESTION'); ?></li>
                </ol>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <a href="<?php echo base_url(); ?>admin/contestquestion/add"
                        class="btn btn-outline-primary waves-effect waves-light"><?php echo $this->lang->line('ADD_CONTEST_QUESTION'); ?></a>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="">
            <div class="">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i>
                        <?php echo $this->lang->line('LIST_CONTEST_QUESTION'); ?> </div>
                    <div class="card-body">
                        <div class="">
                            <button class="btn btn-xs p-1 btn-danger  float-md-left" id="deleteTriger"><i
                                    class="fa fa-trash p-1"></i></button>
                            <table id="default-datatable" class="table-sm table-striped table-bordered" width="100%">
                                <thead class="badge-secondary ">
                                    <tr>
                                        <th width="30"><input type="checkbox" id="bulkDelete" /> </th>
                                        <th style="height: 40px;"><?php echo $this->lang->line('ID'); ?></th>
                                        <th width="300">Question</th>
                                        <th width="300">Question Image</th>
                                        <th width="300">Category</th>

                                        <th>Option A</th>
                                        <th>Option B</th>
                                        <th>Option C</th>
                                        <th>Option D</th>
                                        <th width="10">Answer</th>
                                        <th><?php echo $this->lang->line('ACTION'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/common/footer');?>

<script>
$(document).ready(function() {
    var dataTable = $('#default-datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/contestquestion/fetch_data'; ?>",
            type: "POST"
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
            "searchable": false
        }, ],
    });

    $("#bulkDelete").on('click', function() { // bulk checked
        var status = this.checked;
        $(".deleteRow").each(function() {
            $(this).prop("checked", status);
        });
    });

    $('#deleteTriger').on("click", function(event) { // triggering delete one by one
        if ($('.deleteRow:checked').length > 0) {

            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this question!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var ids = [];
                        $('.deleteRow').each(function() {
                            if ($(this).is(':checked')) {
                                ids.push($(this).val());
                            }
                        });
                        var ids_string = ids.toString(); // array to string conversion 

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'admin/contestquestion/delete_data'; ?>",
                            data: {
                                ids: ids_string
                            },
                            success: function(result) {
                                swal("Deleted!", "question has been deleted.",
                                    "success");

                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            },
                        });

                    } else {
                        swal("Cancelled", "Your question is safe :)", "error");
                    }
                });
        }
    });
});
</script>
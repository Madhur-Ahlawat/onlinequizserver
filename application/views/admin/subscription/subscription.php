<?php $this->load->view('admin/comman/header');?>
<?php $this->load->view('admin/comman/sidemenu');?>

<div class="content-body">
   <div class="row page-titles mx-0">
      <div class="col p-md-0">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/subscription">Subscription</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Subscription</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
  <div class="row">
     <div class="col-12">
        <div class="">
           <div class="card-body">
              <h4 class="card-title">Subscription</h4>

              <div class="row">
                 <?php $i=1;foreach($subplan as $sub){ ?>
                    <div class="col-3">
                       <div class="card">
                          <div class="card-body">
                             <div class="text-center">
                                <span class="display-5"><i class="icon-diamond gradient-4-text"></i></span>
                                <h2 class="mt-3"><?php echo $sub->currency_type;?><?php echo $sub->sub_price;?></h2>
                                <p><?php echo $sub->sub_name;?></p>
                                <a href="<?php echo base_url();?>index.php/admin/editplan?id=<?php echo $sub->sub_id; ?>" class="btn gradient-4 btn-lg border-0 btn-rounded px-3">Edit</a>
                                <a onclick="delete_record('<?php echo $sub->sub_id; ?>','sub')" class="btn gradient-2 btn-lg border-0 btn-rounded px-3">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++;} ?>
            </div>

        </div>
    </div>
</div>
</div>
<!-- #/ container -->
</div>

</div>

<script type="text/javascript">

   function saveTvshow(){

      var tvshow_title=jQuery('input[name=tvshow_title]').val();
      if(tvshow_title==''){
         toastr.error('Please enter Tv show title','failed');
         return false;
     }
     displayLoader();
     var formData = new FormData($("#add_tvshow_form")[0]);
     $.ajax({
         type:'POST',
         url:'<?php echo base_url(); ?>index.php/admin/savetvshow',
         data:formData,
         cache:false,
         contentType: false,
         processData: false,
         dataType: "json",
         success:function(resp){
            hideLoader();
            document.getElementById("add_tvshow_form").reset();
            toastr.success(resp.msg,'success');                
            setTimeout(function(){ location.reload(); }, 500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            hideLoader();
            toastr.error(errorThrown.msg,'failed');         
        }
    });
 }
</script>
<?php
$this->load->view('admin/comman/footerpage');
?>
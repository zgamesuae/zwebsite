<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$admin_id=$session->get('adminLoggedin');  
$sql="select * from admin where admin_id='$admin_id' ";
$adminDetail=$userModel->customQuery($sql);
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
?>   
   <style>
   .coupon-ck{
     width: 18px;
    height: 18px;
    margin: 0 auto;
    display: block;
   }
   </style>
    <!-- BEGIN: Footer-->
    <!-- END: Footer-->
    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/charts/chartist.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/charts/morris.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/vendors/js/timeline/horizontal-timeline.js"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url();?>/admin-assets/js/core/app-menu.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/js/core/app.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/js/scripts/customizer.min.js"></script>
    <script src="<?php echo base_url();?>/admin-assets/js/scripts/footer.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/yahia_supercontrol_js.js"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="<?php echo base_url();?>/admin-assets/js/scripts/pages/dashboard-ecommerce.min.js"></script>
    <!-- END: Page JS-->
        <!-- YAHIA CUSTOME JS -->
   <script src="<?php echo base_url();?>/assets/js/backend_custom_js.js"></script>
   
   <!-- Extra libraries for Jquery UI -->
   <script src="<?php echo base_url()?>/grocery-crud/js/libraries/jquery-ui.js"></script>
   <script src="<?php echo base_url()?>/grocery-crud/js/build/grocery-crud-v2.8.8.10b14e1.js"></script>

    <?php   
    $uri = service('uri'); 
    $uri1=$uri2=$uri3="";
    if(count(@$uri->getSegments())>0){
      $uri1=@$uri->getSegment(1); 
    } 
    if(count(@$uri->getSegments())>1){
      $uri2=@$uri->getSegment(2); 
    } 
    if(count(@$uri->getSegments())>2){
     $uri3=@$uri->getSegment(3);  
   } 
   if(count(@$uri->getSegments())>3){
     $uri4=@$uri->getSegment(4);  
   } 
   if($uri3=="add" || $uri3=="edit"){
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
    <script type="text/javascript">
      $(function() {
        $(".suitable_for,.age,.color,.type").chosen();
      });
    </script>
  <?php } ?>
  <?php
  if($uri3=="products" && $uri2=="Orders"){
    ?>
    <script type="text/javascript">
      $(document).on("click", '.save-changes', function() {
        $('input[name="order_id"]').attr("readonly", false); 
        $('input[name="order_id"]').val(<?php echo $uri4;?>); 
      });
    </script>
  <?php } ?>
  <?php
  if(@$js_files){
    foreach($js_files as $file){ ?>
      <script src="<?php echo $file; ?>"></script>
    <?php }} ?>
    <script>
      $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
          $("#files").on("change", function(e) {
            var files = e.target.files,
            filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
              var f = files[i]
              var fileReader = new FileReader();
              fileReader.onload = (function(e) {
                var file = e.target;
         /* $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });*/
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">-</span>" +
            "</span>").insertAfter("#files");
        });
              fileReader.readAsDataURL(f);
            }
            console.log(files);
          });
        } else {
          alert("Your browser doesn't support to File API")
        }
      });
      
      
      
      
      
      function submitExclusiveSelection() {
   
    var s="?";
    $(document).ready(function(){
      var checkCount = $("input[name='exclusive[]']:checked").length;
      if(checkCount == 0)
      {
        alert("Atleast one exclusive checkbox should be checked.");
      }else{
        $("input:checkbox[name='exclusive[]']:checked").each(function() {
          s=s+"val[]="+$(this).val()+"&" ;
        });
//   s=s+"val="+$('input[name="exclusive[]"]:checked').val();
window.location.href = '<?php echo base_url();?>/supercontrol/Listings/submitExclusiveSelection'+s;
}
});
  }
      
      
      function submitEvergreenSelection() {
   
    var s="?";
    $(document).ready(function(){
      var checkCount = $("input[name='evergreen[]']:checked").length;
      if(checkCount == 0)
      {
        alert("Atleast one evergreen checkbox should be checked.");
      }else{
        $("input:checkbox[name='evergreen[]']:checked").each(function() {
          s=s+"val[]="+$(this).val()+"&" ;
        });
//   s=s+"val="+$('input[name="evergreen[]"]:checked').val();
window.location.href = '<?php echo base_url();?>/supercontrol/Listings/submitEvergreenSelection'+s;
}
});
  }
      
      
       function submitFreebieSelection() {
   
    var s="?";
    $(document).ready(function(){
      var checkCount = $("input[name='freebie[]']:checked").length;
      if(checkCount == 0)
      {
        alert("Atleast one freebie checkbox should be checked.");
      }else{
        $("input:checkbox[name='freebie[]']:checked").each(function() {
          s=s+"val[]="+$(this).val()+"&" ;
        });
//   s=s+"val="+$('input[name="freebie[]"]:checked').val();
window.location.href = '<?php echo base_url();?>/supercontrol/Listings/submitFreebieSelection'+s;
}
});
  }
    </script>
    
    
    
    
    
    
    
    
    
    
    
    
     <?php 
   if(count(@$uri->getSegments())>2){
     if (@$uri->getSegment(3)=="couponSent"   ){
     
     
     $sql="select * from users";
$users=$userModel->customQuery($sql);
     
     
     ?>

<!-- Modal -->
<div id="sendCoupon" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <form method="post" action="<?php echo base_url();?>/supercontrol/Coupon/sendCouponSubmit">
            
            
            
            
             
            <input type="hidden" name="coupon_code" value="<?php echo @$uri->getSegment(4); ?>">
      <div class="modal-header"> <h4 class="modal-title">Send Coupon</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body" style="width:100%;max-height:400px;overflow-x:scroll;">
       <table id="example" class="display" >
        <thead>
            <tr>
                <th>select</th>
                <th>Name</th>
                <th>email</th>
                <th>phone</th>
               
            </tr>
        </thead>
        <tbody>
            <?php if($users) {
            
            foreach($users as $k=>$v){
            ?>
            <tr>
                <td><input type="checkbox" name="user_id[]" value="<?php echo $v->user_id;?>" class="coupon-ck"> </td>
                 <td><?php echo $v->name;?></td>
                <td><?php echo $v->email;?></td>
                <td><?php echo $v->phone;?></td>
                  
                
            </tr>
           <?php }} ?>
        </tbody>
        
    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
        
        <button type="submit" class="btn btn-primary"  >Send Coupon</button>
      </div>
      </form>
    </div>

  </div>
</div>


    
    <script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>




 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  
  
  
  
  <?php }} ?>
  
  
  
  
    <?php 
   if(count(@$uri->getSegments())>2){
     if (@$uri->getSegment(3)=="dateWise" || @$uri->getSegment(3)=="dayWise"  || @$uri->getSegment(3)=="statusWiseOrder" || @$uri->getSegment(3)=="orderExport" || (@$uri->getSegment(3)=="export" AND @$uri->getSegment(2)=="Products")   ){
         ?>
   
    <script>
    $(document).ready(function() {
         $('#dateWiseOrder').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ], "scrollX": true
    } );
    
} );
</script>




 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  
  
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        
         <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
     
  
  
  
  <?php }} ?>
  
  
  </body>
  <!-- END: Body-->
  </html>
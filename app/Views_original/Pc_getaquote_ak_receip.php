<?php
    $session=session();
    $user_id = $session->get('userLoggedin');
    $userModel =  model("App\Models\UserModel");
    if($user_id){
        $sql="select * from users where user_id='".$user_id."'";
        $result=$userModel->customQuery($sql);
    }
    
?>


<style>
   
</style>

<div class="container-fluid col-12 my-3 pc_gamer_query">
    <div class="container p-0">
        <div class="row col-12 m-0 p-0 j-c-center">
            <?php if(isset($status) && $status){
            ?>
            <div class="row rounded px-sm-0 p-lg-5 col-sm-12 col-md-12 col-lg-10 m-0 j-c-center pc_gamer_query_success">
                <i class="fa-solid fa-envelope-circle-check m-3" style="font-size:100px"></i>
                <p class=""> Thank you <?php echo $name?> for contacting us, our team will get in touch with you ASAP with the price of the available options. </p>
            </div>  
            <?php 
            }

            else if(isset($status) && !$status){
            ?>
            <div class="row rounded px-sm-0 p-lg-5 col-sm-12 col-md-12 col-lg-10 m-0 j-c-center pc_gamer_query_error">
                <!-- <i class="fa-solid fa-envelope-circle-check m-3" style="font-size:100px"></i> -->
                <i class="fa-solid fa-circle-xmark m-3" style="font-size:100px"></i>
                <p class="col-12"> Sorry, something went worong please try again later. </p>
            </div> 
            <?php }?>




        </div>
    </div>
</div>  
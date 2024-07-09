<style>
    .image-container{
        height: 200px;
        max-width: 350px;
        background-color: rgb(255, 255, 255);
        /* border: solid 2px rgba(0, 0, 0, 0.096); */
    }

    .image-container img{
        max-height: 100%;
        max-width: 100%;
    }

    .global-img-container{
        height:100%;
    }

    .global-img-container > div:nth-child(2){
        height: 100%;
    }

    .album{
        background-color: rgb(204, 204, 204);
        height: 90%;
        align-content: flex-start;
        overflow-y: scroll; 

    }

    

    .album .img_ctrl{
        position: absolute;
        bottom: 0px;
        left: 0px;
        background-color: rgba(0, 0, 0, 0.507);
        padding: 5px;
        display: none;
    }

    .img_ctrl .del_btn{

    }
</style>


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="container col-12 global-img-container" style="height: calc(100vh - 100px);">
                <div class="row j-c-spacebetween a-a-center ">
                    <h2>Website assets <?php echo sizeof($images) ?></h2>
                    <div class="form-group row col-4 mb-0 img_search_header">
                        <label for="img-search col-auto col-form-label"></label>
                        <input type="text" name="search-image" class="form-control search_image" placeholder="Search by file name">
                    </div>
                </div>
                <div class="row mt-2 p-2 j-c-center">
                    <div class="row col-12 container album p-1 " data-count="0">

                    <?php 
                    if(false):
                    $i=0;
                    // var_dump($images);die();
                    if($images && sizeof($images) > 0):
                        foreach($images as $image):
                            if($i < 50):

                    ?>
                        <div class="col-2 element p-1">
                            <div class="col-12 image-container d-flex a-a-center j-c-center p-0">
                                <div class="img_ctrl col-12">
                                    <button class="del_btn btn btn-danger ">Delete</button>
                                </div>
                                <img src="<?php echo base_url()?>/assets/uploads/<?php echo basename($image)?>" alt="" data="<?php echo basename($image)?>">
                            </div>
                        </div>
                    <?php 
                   
                            endif;
                        $i++;
                        endforeach;
                    endif;
                    endif;
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

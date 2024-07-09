<style>
    .ws-offers-rank{
        position: absolute;
        font-size: 1.5rem;
        color: #788283;
        z-index: 2;
        top: 10px;
        left: 15px;
    }
    .ws-offers-illustration-list .ws-offer-element{
        background-color: #f3f6f9;
        border-radius: 10px;
        border: solid 1px #cfd5db;        
        color: #464646;
    }
    .ws-offers-illustration-list .ws-offer-element img{
        border-radius: 10px;
        overflow: hidden;
    }
    .ws-offers-illustration-list .ws-offer-element span{
        text-decoration: underline;
    }

    @media screen and (max-width: 780px){
        /* .ws-offers-rank{
            top: 10px;
            right: 20px;
        } */
        .ws-offers-illustration-list .ws-offer-element{
            font-size: 1rem!important;
        }
    }
    @media screen and (min-width: 780px){
        /* .ws-offers-rank{
            top: 10px;
            left: 15px;
        } */
        .ws-offers-illustration-list .ws-offer-element{
            font-size: .8rem!important;
        }
    }
</style>

<!-- <div class="col-12 container col-xl-10"> -->
    <div class="row my-3 justify-content-center justify-content-xl-start ws-offers-illustration-list">

        <?php 
        $i=1;
        foreach($GLOBALS["offerModel"]->offers_list as $offer): 
        ?>
        <div class="col-6 col-md-3 col-xl-2 text-center p-2 justify-content-center" style="position:relative">
            <div class="ws-offers-rank font-weight-bold <?php if(!empty($offer->offer_image)) echo "text-white" ?>">
                <span>#<?php echo $i ?></span>
            </div>
            <a class="col-xl-auto ws-offer-element d-flex flex-column align-items-center p-0" href="<?php echo base_url() ?>/product-list/offers?offer_cdn=<?php echo implode("," , array_keys($GLOBALS["offerModel"]->get_offers_conditions_filters([$offer]))) ?>">
                <div class="col-12 p-0">
                    <img width="100%" src="<?php echo base_url() ?>/assets/uploads/<?php echo $offer->offer_image ?>" alt="">
                </div>
                <div class="col-12 p-3 text-black d-flex align-items-center">
                    <span class="text-center"><?php echo lg_put_text($offer->offer_title , $offer->offer_arabic_title) ?></span>
                </div>
            </a>
        </div>
        <?php 
            $i++;
        endforeach; 
        ?>
        
    </div>
<!-- </div> -->
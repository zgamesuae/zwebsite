$('.seriveices_area_sliders').owlCarousel({
    loop:false,
    margin:0,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});
$('.add_ons_for_game').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    nav:true,
    stagePadding: 30,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:4
        },
        1000:{
            items:7
        }
    }
});

$('.screeshot_sldier').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    nav:true,
    stagePadding: 30,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});
$('.blog_listring').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    nav:true,
    stagePadding: 50,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});

$('.category_list_home_page').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    nav:true,
    stagePadding: 50,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});
/*$('.').owlCarousel({
    items:4,
        loop:false,
        center:true,
        margin:10,
        URLhashListener:true,
        autoplayHoverPause:true,
        startPosition: 'URLHash',
    responsive:{
        0:{
            items:4
        },
        600:{
            items:6
        },
        1000:{
            items:4
        }
    }
});*/

var urlhash_nav = $('.dayof_the_play_slider');
urlhash_nav.owlCarousel({
  margin:10,
  nav:false,
   dots:false,
  animateOut: 'fadeOut',
  URLhashListener: true,
  startPosition: 'URLHash',
   responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});


urlhash_nav.on('changed.owl.carousel', function(event) {
  location.hash = 'slide' + event.property.value;
})
$('.gift_wrape_slider').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    autoWidth:true,
    nav:false,
    responsive:{
        0:{
            items:4
        },
        600:{
            items:6
        },
        1000:{
            items:8
        }
    }
});

$('.category_boxes').owlCarousel({
    loop:false,rewind: true,
    margin:10,
    dot:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});
/*$('.gift_wrape_slider').owlCarousel({
    loop:false,
    margin:10,
    dots:false,
    autoWidth:true,
    nav:false,
    responsive:{
        0:{
            items:4
        },
        600:{
            items:6
        },
        1000:{
            items:8
        }
    }
});

$('.category_boxes').owlCarousel({
    loop:true,
    margin:10,
    dot:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});
$('.age_box_slider').owlCarousel({
    loop:true,
    margin:10,
    dot:false,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});




$('.products_slider').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
})
$('.products_similar').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:2
        }
    }
})*/


$('.simlilar_products_dedsktop').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:true,
    stagePadding: 30,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
});
$('.products_similar').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:2
        }
    }
});
$('.chnage_languages').click(function(){
$('.languages_poup').addClass('show');
});
$('.close_header').click(function(){
$('.languages_poup').removeClass('show');
});

$('#menu_optn_mobile').click(function(){
$('div#menu_parent_coumn').css('left','0px');
});
$('.menui_icon_icon').click(function(){
$('div#menu_parent_coumn').css('left','-100%');
});

/*$(document).ready(function(){
    $('.gallery_open_1').lightGallery();
});*/
$('.filter_itm_header').click(function(){
$(this).parent().children('.filter_item_data').toggle();
});
$('.dropdown_m_menu svg').click(function(){
$(this).parent().toggleClass('hideshow');
$(this).parent().parent().children('.drop_drow_menu').toggle();
$(this).parent().parent().children('.open_menu_mobile_s').toggle();
});
$('.dropdown_m_menu_2_step svg').click(function(){
$(this).parent().parent().children('.show_mega_menu_full').toggle();
});


$('.open_hide_toggle').click(function(){
    $(this).parent().parent().children('ul').toggle();
    $(this).toggleClass('open');
});
$('#secrh_icon_iopen').click(function(){
    $('#search_column_main').toggle();
});


$('#cart_box_open').click(function(){
    $('.shopping-cart').toggle();
});
$('.shopping-cart-total.remove_cart_close').click(function(){
    $('.shopping-cart').toggle();
});
$('#filter_open_mobile').click(function(){
    $('form.serahac_filter_form').toggle();
});
$('.close_serach_products').click(function(){
    $('form.serahac_filter_form').toggle();
});


$(document).on("click", ".collapse_hide", function() {
  var collapse = $(this).closest(".collapse");
  $(collapse).collapse('toggle');
});


$('.toggle_button').click(function(){
    $(this).parent().parent().children('.body_data_open').toggle();
});


function gift_wrape(selector){
    $(selector).toggle();
}


$('.eye_password').click(function(){
    if($(this).attr('data_val')=='text'){
          $(this).attr('data_val','password');
        var value =  'text';
    }else{
        $(this).attr('data_val','text');
        var value = 'password';
    }
    $(this).parent().children('input').attr('type',value);
});

$(document).on("click", ".sort_by_option_news", function() {
    $('.drop_down_sort_by_option').toggle();
});


$('.filter_category .titie_heasder').click(function(){
            $(this).parent().children('.cate_data_body').toggle();
        });

        $('#filter_open_mobile').click(function(){
    $('.product_filter ').toggle();
});
$('.close_serach_products').click(function(){
    $('.product_filter ').toggle();
});

$(document).on('click', '.qty_option .qty_up', function(event) {
    var current_val = $('.product_qty_single_page').val();
    var new_val = parseFloat(current_val) + parseFloat(1); 
    $('.product_qty_single_page').val(new_val)
});
$(document).on('click', '.qty_option .qty_down', function(event) {
    var current_val = $('.product_qty_single_page').val();
    if(current_val==1){ }else{
    var new_val = parseFloat(current_val) - parseFloat(1); 
    $('.product_qty_single_page').val(new_val);
    }
});


$('.popup_design_close').click(function(){
    $('.add_to_card_popup').toggleClass('show_indesktop');
});

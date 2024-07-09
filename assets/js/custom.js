
$('.ws-shopby-genre-carousel').owlCarousel({
    center: false,
    loop:false,
    nav: true,
    dots: true,
    margin: 80,
    items: 4,
    responsive:{
      0:{
        items: 2,
      },
      768:{
        items: 2,
      },
      990:{
        items: 4,
      }
    },
    onInitialized: coverFlowEfx,
    onTranslate: coverFlowEfx,
  });

$('.service_box_animated_sliders').owlCarousel({
    center: true,
    loop:true,
    nav: true,
    items: 5,
    responsive:{
      0:{
        items: 2,
      },
      768:{
        items: 3,
      },
      990:{
        items: 7,
      }
    },
    onInitialized: coverFlowEfx,
    onTranslate: coverFlowEfx,
  });
  
  function coverFlowEfx(e){
    idx = e.item.index;
    $('.service_box_animated_sliders .owl-item.big').removeClass('big');
    $('.service_box_animated_sliders .owl-item.medium').removeClass('medium');
    $('.service_box_animated_sliders .owl-item.mdright').removeClass('mdright');
    $('.service_box_animated_sliders .owl-item.mdleft').removeClass('mdleft');
    $('.service_box_animated_sliders .owl-item.smallRight').removeClass('smallRight');
    $('.service_box_animated_sliders .owl-item.smallLeft').removeClass('smallLeft');
    $('.service_box_animated_sliders .owl-item.smallrightxl').removeClass('smallrightxl');
    $('.service_box_animated_sliders .owl-item.smallLeftxl').removeClass('smallLeftxl');
    $('.service_box_animated_sliders .owl-item').eq(idx -1).addClass('medium mdleft');
    $('.service_box_animated_sliders .owl-item').eq(idx).addClass('big');
    $('.service_box_animated_sliders .owl-item').eq(idx + 1).addClass('medium mdright');
    $('.service_box_animated_sliders .owl-item').eq(idx + 2).addClass('smallRight');
    $('.service_box_animated_sliders .owl-item').eq(idx - 2).addClass('smallLeft');
    $('.service_box_animated_sliders .owl-item').eq(idx - 3).addClass('smallLeftxl');
    $('.service_box_animated_sliders .owl-item').eq(idx + 3).addClass('smallrightxl');
  }
  
  var click = false;
  
  $('#play-carousel').click(function(evt) {
    click = !click;
    if(click){
      $('.status').html('Autoplay: ON');
      $('.owl-carousel').trigger('play.owl.autoplay', [1000, 1000]);
      $(this).html("Stop");
    } else {
      $('.owl-carousel').trigger('stop.owl.autoplay');
      $(this).html("Play");
      $('.status').html('Autoplay: OFF');
    }
  
  });
  
  $('.category_single_page_slider').owlCarousel({
      margin:10,
      dots:true,
      nav:true,
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
  
  $('.shop_by_cate_desktop_slider_row_with_box').owlCarousel({
      margin:10,
      dots:true,
      nav:true,
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
  
  $('.category_severn_box_sliders').owlCarousel({
      margin:10,
      dots:true,
      nav:true,
      responsive:{
          0:{
              items:2
          },
          400:{
              items:3
          },
          600:{
              items:3
          },
          800:{
              items:4
          },
          1000:{
              items:5
          },
          1200:{
              items:7
          }
      }
  });
  
  
  
  $('.cate_sliders_design_two').owlCarousel({
      
      margin:10,
      dots:true,
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
  
  
  $('.slider_center_four_items_s').owlCarousel({
      
      margin:10,
      dots:true,
      nav:true,
      responsive:{
          0:{
              items:2
          },
          600:{
              items:3
          },
          1000:{
              items:4
          }
      }
  });
  
  
  
  $('.footer_one_column_sliders').owlCarousel({
      
      margin:10,
      dots:true,
      nav:true,
      autoplay:true,
      autoplayTimeout:6000,
      autoplayHoverPause:false,
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
  
  $('.two_rows_grid_sliders').owlCarousel({
      
      margin:10,
      dots:true,
      nav:true,
      autoplay:true,
      autoplayTimeout:6000,
      autoplayHoverPause:false,
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
  
  $('.new_category_list_esign').owlCarousel({
      
      margin:10,
      dots:true,
      nav:true,
      responsive:{
          0:{
              items:3
          },
          600:{
              items:4
          },
          1000:{
              items:8
          }
      }
  });
  
  $('.seriveices_area_sliders').owlCarousel({
      
      margin:0,
      dots:true,
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
      
      margin:10,
      dots:true,
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
      
      margin:10,
      dots:true,
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
      
      margin:10,
      dots:true,
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
      
      dots:true,
      nav:true,
      autoplay:true,
      autoplayTimeout:6000,
      autoplayHoverPause:false,
      responsive:{
        0:{
            items:2,
            margin:7,
            stagePadding: 0
        },
        600:{
            items:3,
            margin:10,
            stagePadding: 0
        },
        1000:{
            stagePadding: 0,
            margin:10,
            items:4
        },
        1200:{
            stagePadding: 0,
            margin:10,
            items:4
        },

        1400:{
            margin:10,
            items: 6,
        }
      }
  });

  $('.product_carrousel_vertical').owlCarousel({
      
    dots:false,
    nav:true,
    autoplay:false,
    autoplayTimeout:6000,
    autoplayHoverPause:false,
    responsive:{
      0:{
          items:2,
          margin:7,
          stagePadding: 0
      },
      770:{
          items:3,
          margin:7,
          stagePadding: 0
      },
      1000:{
          items:2,
          margin:7,
          stagePadding: 0
      },

      1400:{
          items:2,
          margin:7,
          stagePadding: 0
      },
      
      
    }
});
  
  $('.catpage_h_slider').owlCarousel({
      
      loop:false,
      margin:10,
      nav:false,
      responsive:{
          0:{
              items:2
          },
          600:{
              items:3
          },
          1000:{
              items:4
          }
      }
  });
  
  $('.home_category_slider_top').owlCarousel({
      
      loop:false,
      margin:50,
      dots: false,
      nav:false,
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
  
    $('.m_home_slider').owlCarousel({
      
      loop:true,
      autoplay:true,
      margin:0,
      nav:true,
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
  
  
  $('.homepage_buildpc').owlCarousel({
      
      loop:false,
      margin:10,
      nav:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:2
          },
          1000:{
              items:2
          }
      }
  });
  
  $('.catpage_price_slider').owlCarousel({
      
      loop:false,
      margin:10,
      nav:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:3
          },
          1000:{
              items:5
          }
      }
  });
  
  $('.catpage_h_slider_two').owlCarousel({
      
      loop:false,
      margin:10,
      nav:false,
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
  $('.catpage_bts_slider').owlCarousel({
      
      loop:false,
      margin:0,
      nav:true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:2,
          },
          1000:{
              items:3
          }
      }
  });
  
  
  /*cate_on.on('changed.owl.carousel', function(event) {
      $('.owl-item .item').removeClass('is_item_running');
      $(".category_list_home_page .owl-item.active .item").addClass('is_item_running');
  })
  */
  
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
    nav:true,
     dots:true,
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
  $('.products_list').owlCarousel({
      loop:false,
      margin:10,
      responsive:{
          0:{
              dots:true,
              nav:false,
              items:3
          },
          600:{
              dots:false,
              nav:true,
              items:2
          },
          1000:{
              dots:false,
              nav:true,
              stagePadding: 50,
              items:3
          }
      }
  });
  
  $('.Package_products_list').owlCarousel({
      
      margin:2,
      margin:10,
      autoplay:true,
      autoplayTimeout:6000,
      autoplayHoverPause:true,
      responsive:{
          0:{
              dots:true,
              nav:true,
              items:1
          },
          600:{
              dots:true,
              nav:true,
              items:1
          },
          1000:{
              dots:true,
              nav:true,
              stagePadding: 2,
              items:1
          }
      }
  });
  $('.gift_wrape_slider').owlCarousel({
      loop:false,
      margin:10,
      dots:true,
      autoWidth:true,
      nav:true,
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
      dots:true,
      autoWidth:true,
      nav:true,
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
      
      margin:10,
      dots:true,
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
      
      margin:10,
      dots:true,
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
  
  $(document).ready(function(){
      $('.gallery_open_1').lightGallery();
    //   _cart($(".add_to_card_popup .card_popup_esign"))
  });
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
  
  
  
  var drop_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>';
  //$('.drop_down_ion').append(drop_icon);
  
  $('.toggle_button').click(function(){
      $(this).parent().parent().children('.body_data_open').toggle();
  });
  
  
  function gift_wrape(selector){
      $(selector).toggle();
  }
  
  
  $(document).on("click" , ".eye_password" , function(){
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
  
  $('#filter_open_mobile').click(function() {
    $('.product_filter').toggle();
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
  
  $(document).ready(function() {
  $('.quantitynumber .minus').click(function () {
      var $input = $(this).parent().find('input');
      if($input.val()>1){
      var count = parseInt($input.val()) - 1;
      count = count < 1 ? 1 : count;
      $input.val(count);
      $input.change();
      return false;
      }
  });
  $('.quantitynumber .plus').click(function () {
      var $input = $(this).parent().find('input');
      $input.val(parseInt($input.val()) + 1);
      $input.change();
      return false;
  });


  });
  
      
      
      
      
  
//   $(window).scroll(function (event) {
//       var scroll = $(window).scrollTop();
//       var footer_top = $("footer").offset().top;
//       var amount_s = footer_top-parseInt(100);
//      console.log(footer_top);
//       if(scroll>amount_s){
//           $('body').addClass('remove_fixed_filters_option');
//       }else{
//           $('body').removeClass('remove_fixed_filters_option');
//       }
//       // Do something
//   });
  
  $("#op_type").change(function(){
    $(".config_infos").toggle(100);

  })
  
  $("select#pp_bundle_opt_select").change(function(){
    p_id=$(this).parents(".products_details").attr("product_id")
    option_values = $("form.products_add_to_cart select[name='bundle_opt[]']").serializeArray()
    options = Array()
    option_values.forEach(function(element){
        options.push(element.value)
    })

    $.ajax({
        type: 'post',
        url: base_url+'page/updateprice',
        data: {
            'product_id':p_id,
            'bundle_opt_id':options

        },
        success: function(data1){

          data1=JSON.parse(data1);
          $(".offer-price.card-text span:first-child").text(data1["response"])
          tabby_product_page.price = data1["response"]
          new TabbyPromo(tabby_product_page)

          $("#loading").hide();
         
          
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
        }
      }); 
  })
  
  //to be removed
//   $("#search_bar").on("keyup",function(){
//       $.ajax({
//         type: 'post',
//         url: base_url+'page/search_keyword',
//         data: {
//             'keyword':$(this).val(),
//         },
//         success: function(data){
//             // console.log(data)
//             data = JSON.parse(data)
            
//           if(data["status"] = 1)
//           $(".search_form .result").html(data["result"])


//           else 
//           console.log("Error happened")

//           $("#loading").hide();
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//           $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
//         }
//       }).done(function(){
//       })
//   })

//   $("#search_bar").on("focus",function(){
//     $(this).trigger("keyup")
//   })
  //to be removed

//   $(document).on("click",function(event){
//     if(!event.originalEvent.path.includes($(".result-data")[0]))
//     $(".search_form .result").html("")
//   })
  
//   To be removed
//   window.onscroll = function() {myFunction()};

//   var navbar = $(".menu_bottom_div");
//   var header = $("header#nav_bar")
//   var sticky = navbar.offset().top;

//   function myFunction() {
//       if (window.pageYOffset >= sticky) {
//         t = "<div class='support'></div>"
//         if($("div.support").length == 0){
//             // $(t).height(160)
//             $(t).prependTo("body")
//             $(".support").height("160")

//         }
        
//         // new_header=header.clone().addClass("sticky").removeClass("org").prependTo("body")
//         // new_header.find(".header_top").remove()
//           header.addClass("sticky")
//           $(".sticky .header_top").hide()
//         //   header.hide()
//       } else {
//         // $("header.sticky").remove()
//           header.removeClass("sticky");
//           $(".support").remove()
//           $(".header_top").show()

//         //   header.show()
  
//       }
//   }
  
  function get_form(key , destination =null){
    $.ajax({
        type: "GET",
        url: base_url+"/auth/get_form/"+key+"/"+destination,
        data: {},
        success: function(data){ 
        //   var obj = jQuery.parseJSON(data);
          if( data=="error"){
            alert("sorry")
          }
          else{  
            if(destination == null || destination == 'null')  
            $("#login-modal .modal-body").html(data)
            else
            $("#"+destination).html(data)

     //   window.location.href = baseurl + 'profile/dashboard';
         }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
    //   $('#buyer_login_form_message').show();
    //   $('#buyer_login_form_message').html(textStatus);
    }
    });
}

  function resend_otp(country_code , phone , dest=null){
      $.ajax({
          type: "post",
          url: base_url+"/auth/loginWithOTP",
          data: {country_code: country_code , phone : phone , pop : (dest == null || dest == 'null') ? true : false , dest : dest},
          success: function(data){ 
              var obj = jQuery.parseJSON(data);
              
              if( obj[0]=="error"){
                $('#loginWithOTPMssage').show();
                $('#loginWithOTPMssage').html(obj[1]);
              }
              
              else{
                // $('#loginWithOTPMssage').html(obj[1]);
                if(dest == null || dest == 'null')
                $('#login-modal .modal-body').html(obj[1]);
                else
                $('#'+dest).html(obj[1]);

        
                $('#vphone').val( $('#pn').val());
                $('#loginWithOTPMssage').show();
              //  $("#loginWithOTP").hide();
                $("#verifyOTP").show();
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {  
              $('#loginWithOTPMssage').show();
              $('#loginWithOTPMssage').html(textStatus);
            }
      });
  }

//   payment method change events

$(document).ready(function(){
    $('.payment-method input[type="radio"]').each(function(index , value){
        if($(value).attr("checked"))
        $(value).parents(".payment-method").addClass("selected")
    })

    
    // Modal NS notification
        if($("#generalmodal").data("modalAutoshow")){
            $("#generalmodal").modal("show")
        }
    // Modal NS notification 

})

$(".payment-method").click(function(){
    $(".payment-method").removeClass("selected")
    $(this).addClass("selected")
})
// end payment method events

// Language change

$("select[name='language_change']").change(function(){
    $.post(base_url+"/Page/change_language/"+$(this).val() , {} , function(data){
        data = JSON.parse(data)
        if(data["status"] == 1)
        location.reload()
    })
})

function change_language(code){
    $.post(base_url+"/Page/change_language/"+code , {} , function(data){
        data = JSON.parse(data)
        if(data["status"] == 1)
        location.reload()
    })
}
// end language change

// plus sign annimation in menu

function rotat_line(elem){
    $(elem).find('.to_turn').toggleClass("rotate_elem")
}

// END plus sign annimation in menu

// Oculus intrest registration
$("select.o_t").change(function(){
    formgroup =  $("form.oculus-preorder .form-group.store")
    if($(this).val() == "store"){
        select = 
        // '<label class="form-label col-12 mb-3 px-0" for="country">Preferred buying option:</label>'+
        '<select class="form-control col-12" name="store" id="store">'+
            '<option value="Dubai Mall store">Dubai Mall store (Dubai)</option>'+
            '<option value="Dubai Hills Mall store">Dubai Hills Mall store (Dubai)</option>'+
            '<option value="Al Warqa store">Al Warqa store (Dubai)</option>'+
            '<option value="City Center Al Zahia store">City Center Al Zahia store (Sharjah)</option>'+
        '</select>'
        
        formgroup.show()
        formgroup.append($(select))

    }

    else{
        formgroup.find("select#store").remove()
        formgroup.hide()
    }
})
// Oculus intrest registration

// checkout one click
$(".account_wishlist a.cart").mouseenter(function(){
    $(".add_to_card_popup").addClass("show_indesktop")
    $(".add_to_card_popup").show()
})

// To be removed
// $(".add_to_card_popup").on("click" , ".remove_prdct" , function(){
//     pid = $(this).parents(".products_list_gg").data("id")
//     var parent = $(this).parents(".products_list_gg")
//     $.get(base_url+"cart" , {"rcid" : pid , "blank" : true} , function(data){
//         data = JSON.parse(data)
        
//         if(data["status"] && !isNaN(data["totalcart"]) && data["totalcart"] !== null){
            
//             if(data["totalcart"] == 0)
//             _cart($(".add_to_card_popup .card_popup_esign"))
//             else
//             parent.remove()
//             $("#counter_cart").html(data["totalcart"])
//         }
//     })
// })
// checkout one click

// Our stores page

    $(".stores_container").toggle()
    $(".stores-location").click(function(){
        $(this).siblings(".stores-rail").find(".stores_container").toggle()
        $(this).find("i").toggleClass("fa-caret-down")
        $(this).find("i").toggleClass("fa-caret-up")
    })

    $(".store-detail").click(function (params) {
        store_id = $(this).parents(".store").data("id")
        modal = $("#store-preview")
        modal.find(".modal-body").html("")
        modal.find(".modal-header h3").html("Store Name")
        $.ajax({
            type: 'get',
            url: base_url+'stores/get_store_info/'+store_id,
            data: {},
            success: function(store){
                store=JSON.parse(store);
                if(store.status == true){
                    modal.find(".modal-body").html(store.store_detail)
                    modal.find(".modal-header h3").html(store.store_title)
                    modal.modal("show")
                }
                

            
            },
            error: function(jqXHR, textStatus, errorThrown) {
            
            }
        }); 
    })

// Our stores page

// Winter snow 
// snowStorm.targetElement = 'snow-target';

// ENBD offer learn more
  $(".enbd_learn_more a").click(function(){
    var generalModal = $("#generalmodal")
    generalModal.find(".modal-header h2").html($(this).data("bsModalTitle"))
    generalModal.find(".modal-body > .row").html("<p class='col-12 p-0'>"+$(this).data("bsModalContent")+"</p>")
  })
// ENBD offer learn more


  
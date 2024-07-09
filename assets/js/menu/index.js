
// Load cart function
function _cart(ele){
    $.get(base_url+"/page/getcart" , {} , function(data){
        data = JSON.parse(data)
        if(data["cart"] !== "")
        ele.html(data["cart"])
    })
}
// Load cart function

// Change language function 
function change_language(code){
    $.post(base_url+"/Page/change_language/"+code , {} , function(data){
        data = JSON.parse(data)
        if(data["status"] == 1)
        location.reload()
    })
}
// Change language function 


// Sticky Menu
window.onscroll = function() {myFunction()};
    var header = $("header")
    var site_id_height = $("header .site-identity").height()
    var site_top_bar = $("header .top-bar").height()
    var site_menu = $("header .menu").height()
    var sticky = header.height();

function myFunction() {
    
    if (window.pageYOffset >= sticky) {
        header.find(".site-identity").hide()
        header.addClass("sticky")
    } else if(window.pageYOffset == 0){
        header.find(".site-identity").show()
        header.removeClass("sticky");
    }
}
// Sticky Menu

// Load Ask in Store form
function ask_in_store(country , modal){
    
    $.ajax({
        type: 'get',
        url: base_url+'stores/ask_in_store/'+country,
        data: {},
        success: function(data){
            data = JSON.parse(data)
            // console.log(data)
            if(data["html"].trim() !== ""){
                modal.find(".modal-body").html(data["html"])
                modal.modal("show")
            }
          $("#loading").hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      }).done(function(){
          
      })
}
function get_store_info(store , area){
    
    $.ajax({
        type: 'get',
        url: base_url+'stores/store_info/'+store,
        data: {},
        success: function(data){
            if(data !== ""){
                area.html(data)
            }
          $("#loading").hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      }).done(function(){
          
      })
}

$(document).ready(function(){

    // Ask In-Store Request
    $("button.ws-btn-ask-instore").click(function(){
        ask_in_store($(this).data("country") , $("#askinstoremodal"))
    })
    $(document).on("change" , "select#ais-countries", function(){
        ask_in_store($(this).val() , $("#askinstoremodal"))
    })

    $(document).on("change" , "select#ais-stores", function(){
        $(".ws-store-info-area").html("")
        get_store_info($(this).val() , $(".ws-store-info-area"))
    })
    // Ask In-Store Request

    // New Menu
    $(".main-menu > ul .ws-main-menu-element-1:first-child > div:first-child").click(function(event){
        // if($(event.target).is($(this)))
        $(this).parent().find(".main-menu-categories").toggle()
        $(".ws-overlay").toggle()
    })

    // category Search bar filter
    $(".ws-search-category-filter").click(function(){
        $(".search-category-filter-list").toggle()
    })

    

    $("li.ws-sc-filter").click(function(){
        index = $(this).index()
        index = (index == 0) ? 1 : index
        $("select#ws-search-category").find("option")[index-1].selected = true
        console.log(index , $("select#ws-search-category").val())
        $(this).addClass("selected")
        $(this).siblings().removeClass("selected")
        $(this).parent("ul").siblings(".ws-search-category-filter").find("p").html($(this).text())
        $(this).parent().toggle()
    })
    // $("li.ws-sc-filter.selected").trigger("click")
    // category Search bar filter

    // if ($(window).width() < 768) {
    //     $(".menu-element.layer").click(function(){
    //         $(this).find(".ws-sm").toggle()
    //     })
    // }
    // $(".categories-side .menu-element.layer .sub-categories-sub .menu-element.layer").mouseenter(function(){
    //     $(".category-media").css({"left" : "300%"}) 
    // })
    // $(".categories-side .menu-element.layer .sub-categories-sub .menu-element.layer").mouseleave(function(){
    //     $(".category-media").css({"left" : "200%"}) 
    // })
    // $(".categories-side .menu-element.layer").mouseleave(function(){
    //     $(".category-media").css({"left" : "100%"}) 
    // })
    // $(".categories-side").mouseleave(function(){
    //     $(this).slideUp()
    // })
    // New Menu

})

// Website overlay on events
$("ul.main-menu-elements li.parent-element").mouseenter(function(){
    if($(this).children(".children-elements").length > 0)
    $("body .ws-overlay").show()
})
$("ul.main-menu-elements li.parent-element").mouseleave(function(){
    if($(this).children(".children-elements").length > 0)
    $("body .ws-overlay").hide()
})
// Website overlay on events

$(".children-elements .sub-elements > ul > li.child-element span.toggler").click(function(e){
    // if(e.target.classList.contains("child-element"))
    parent = $(this).parent("li.child-element")
    parent.siblings("li").each(function(index , element){
        // $(element).find(".schildren-elements").hide()
    })
    parent.children(".schildren-elements").toggle()
})



$(".main-menu .close-menu i").click(function(){
    $(this).parents(".menu").hide()
    $(".ws-overlay").hide()

})

$(".menu-bars").click(function(){
    $(".menu").show()
})

// User menu toggler
$(".ws-user i").click(function(){
    $(this).siblings(".user-menu").toggle()
})


// User Cart 

$(".ws-cart i.fa-cart-shopping").click(function(){
    $(".ws-user-cart").toggleClass("hide show")
    _cart($(".ws-user-cart-content .ws-cart-elements"))
})

$(".ws-user-cart .ws-user-cart-close i").click(function(){
    $(".ws-user-cart").toggleClass("hide show")
})

// Seach bar action
let typingTimer
$("#search_bar,#search_bar_mobile").on("input",function(){
    clearTimeout(typingTimer);
    keyword = $(this).val().trim()
    typingTimer = setTimeout(
        function(){

            $.ajax({
              type: 'post',
              url: base_url+'/page/search_keyword',
              data: {
                  'keyword': keyword,
              },
              success: function(data){
                  // console.log(data)
                  data = JSON.parse(data)

                if(data["status"] = 1){
                    $(".search_form .result").show()
                    $(".search_form .result").html(data["result"])
                }
                else{
                    console.log("Error happened")
                    $(".search_form .result").hide()
                }
            

            
                $("#loading").hide();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
              }
            }).done(function(){
                $("body .ws-overlay").show()
            })
    }, 500)
})

$("#search_bar,#search_bar_mobile").on("focus",function(){
  $(this).trigger("keyup")
})

$("#search_bar,#search_bar_mobile").on("blur",function(){
    $(".result").slideUp()
    $("body .ws-overlay").hide()
})

// Seach bar action

// Add to cart Action
$(document).on('submit','.buy-now-form', function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var fdata = $(this).serializeArray();
    var p=fdata[0].value;
    var i=fdata[1].value;
    err_container = $('.errors-back')
    product = {
        "content_type": "product",
        "quantity": $(this).find("input[name='quantity']").val(),
        "description": fdata[0].value,
        "content_id": $(this).data("sku"),
        "currency": currency,
        "value": $(this).data("price"),
    }
    // trigger pixel events
    ttq.track('AddToCart' , product)
    // trigger pixel events
    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: formData,
      success: function(data1){ 
        var obj = JSON.parse(data1);
        if(obj["errors"] == null){
            if( obj['action']=="Add to cart"){
                if( $(".ws-user-cart").hasClass("hide"))
                $(".ws-user-cart").toggleClass("hide show")
                _cart($(".ws-user-cart-content .ws-cart-elements"))
                // update the cart icone counter
                $(".counter_cart").html(obj['value']);
            } 
            
            else{
              $("#toast").html(' <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z" fill="rgba(16,188,89,1)"/></svg>'+obj['msg']); 
              $("#toast").fadeIn().delay(2000).fadeOut();
            }
        }
  
        else{
            err_container.children("span.error-content").html(obj["errors"])
            err_container.show()
        }
    //   $(".shopping-cart").html(data);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        $("#toast").fadeIn();
    }
  });
});
// Add to cart Action


// Remove from cart action
$(".ws-cart-elements").on("click" , ".remove_prdct" , function(){
    pid = $(this).parents(".products_list_gg").data("id")
    var parent = $(this).parents(".products_list_gg")
    $.get(base_url+"cart" , {"rcid" : pid , "blank" : true} , function(data){
        data = JSON.parse(data)
        if(data["status"] && !isNaN(data["totalcart"]) && data["totalcart"] !== null){
            _cart($(".ws-user-cart-content .ws-cart-elements"))
            parent.remove()
            // update the cart icone counter
            $(".counter_cart").html(data['totalcart']);
        }
    })
})
// Remove from cart action


// Search bar submit
$(".search_form .ws-search-button").click(function(){
    form= $(this).parent().parent("form")

    keyword = form.children("input").val().trim()
    if(keyword!=""){
        form.children("input").val(keyword)
        form.submit()
    }
})
// Search bar submit


// Change address in checkout page
$(".ws-checkout-change-address").click(function(){
    modal = $("#changeAddressModla .modal-body")
    $.ajax({
        url : base_url+"/profile/changeaddress/change",
        type : "get",
        data: {},
        success : function(response){
            modal.html(response)
        },
        error : function(){} 

    })
})

$("body").on("submit" , ".ws-change-addrss-form" , function(e){
    e.preventDefault()
    id = $(this).serializeArray()[0].value
    $.ajax({
        url: base_url+"/profile/act_addrss/"+id,
        type: "POST",
        data: {},
        success: function(data){
            data = JSON.parse(data)
            if(data.status){
                location.reload()
            }
            else
            alert("Something went wrong")
        },
        error: function(error){

        }
    })
})

// Change address in checkout page


// Blog Header
// Sticky Menu
$(".ws-blogs .blogs").scroll(function(){

    if ($(".ws-blogs .blogs")[0].scrollTop > 0) {
        $(".ws-blog-heading").slideUp()
        $(".ws-blog-heading").an("ws-hide")

    } else if($(".ws-blogs .blogs")[0].scrollTop == 0){
        $(".ws-blog-heading").slideDown()
    }

});
// Sticky Menu
// Blog Header

// CountDown Trigger
var deadline = new Date(Date.parse($("#clockdiv").data("end")));
initializeClock('clockdiv', deadline);
// CountDown Trigger

// resend Validate email
$(document).on("click" , "a#resend-verification" , function(e){
    e.preventDefault()

    $.post($(this).attr("url") , {} , function(data){
        data = JSON.parse(data)
        $('#buyer_login_form_message').show();
        $('#buyer_login_form_message').html(data["msg"]);
    })
}) 



function update_bundle_price(form){
    var total = 0
    $status = true
    if(form.find(".check").length > 0){
        if(form.find(".checked").length > 0){
            form.find(".ws-bundle-prop-element .check.checked , .ws-bundle-prop-element .default-checked").each(function(index , element){
                total += parseInt($(element).parents(".ws-bundle-prop-element")[0].dataset.price)
            })
            total = total - parseInt(form.find(".ws-bundle-prop-action")[0].dataset.discount)
            form.find(".ws-bundle-prop-action .bundle-price").html(total)
    
            $status = false
        }
    }
    else if(form.find(".default-checked").length == form.find(".ws-bundle-prop-element").length){
        $status = false
    }

    form.find(".ws-bundle-prop-action").attr("disabled" , $status)

    
}

$(document).ready(function(){
    $("form.bndle_add_to_cart .ws-bundle-offer-title").click(function(){
        $(this).siblings(".ws-bundle-content").slideToggle()
    })
    $("form.bndle_add_to_cart").each(function(index , element){
        update_bundle_price($(element))
        if(index > 0)
        $(element).children(".ws-bundle-content").slideUp()
    })
    $(".ws-bundle-prop-element .check").click(function(){
        $(this).toggleClass("checked")
        $(this).siblings("input[type='checkbox']").trigger("click")
        update_bundle_price($(this).parents("form"))
        
    })

    $(".ws-bundle-prop-element img").click(function(){
        $(this).parents(".ws-bundle-prop-element").find(".check").trigger("click")
    })



    // Add to cart Action
    $(document).on('submit','.bndle_add_to_cart', function(e){
        e.preventDefault();

        var formData = $(this).serialize();
        var fdata = $(this).serializeArray();

        err_container = $('.errors-back')   
        

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
})
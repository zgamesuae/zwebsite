
function get_attribute_options(attribute_id , option_id , requested_attributes , parent){
    $.get("https://zamzamgames.com/variations/update_attrbite_sections" , {"attribute" : attribute_id , "option" : option_id , "req_attributes" : requested_attributes , "parent" : parent} , function(data){
        // console.log(JSON.parse(data).length)
        data =JSON.parse(data)
        if(data.length > 0){
            select_element = $("select[attribute_id='"+requested_attributes[0]+"']")
            ui_element = select_element.siblings("ul").html("")
            // console.log(data)
            select_element.html("")
            select_element.append($('<option value="" selected></option>'))
            data.forEach(element => {
                stat = (element.available_stock > 0) ? "active" : "disabled"
                e = $('<option value="'+element.option_id+'">'+element.name+'</option>')
                l = $("<li class='col-3 p-0 mx-2 var_option d-flex-column a-a-center border "+stat+"' style='text-align:center'><span>"+element.name+"</span></li>")
                select_element.append(e)
                ui_element.append(l)
            });
        }
        
    })
}

function get_product_variation_price(variation , parent){
    $.get("https://zamzamgames.com/variations/update_variable_price" , {"variation" : variation , "parent" : parent} , function(data){
        data = JSON.parse(data)
        console.log(data)
        if(data.price !== null){
            if(data.offer_price !== null){
                $("div.card-subtitle").html("<span> "+data.price+" <span> AED </span> </span>")
                $("p.offer-price").html("<span style='font-size: inherit;font-weight:inherit'>"+data.offer_price+"</span><span>AED</span>")
            }
            else{
                $("div.card-subtitle").html("")
                $("p.offer-price").html("<span style='font-size: inherit;font-weight:inherit'>"+data.price+"</span><span>AED</span>")
            }

            $("form.products_add_to_cart input[name='product_image']").val(function(index , value){
                if(data.image !== null)
                return data.image 
            })

            $("form.products_add_to_cart input[name='product_name']").val(function(index , value){
                if(data.name !== null)
                return data.name 
            })

        }
    })
}

var variations = []

$(document).ready(function(){
    $(".product_variations").on("click" , ".var_option.active" , function(){
        attributes_ids = []
        if($(this).parents("ul").find(".var_option.selected").hasClass("ybr")){
            $(this).parents("ul").find(".var_option.selected").removeClass("selected ybr")
            $(this).addClass("selected ybr")
        }

        else{
            $(this).parents("ul").find(".var_option.selected").removeClass("selected")
            $(this).addClass("selected")
        }

        $(this).parents('ul').siblings("select").find("option[selected]").removeAttr("selected");
        $(this).parents('ul').siblings("select").find("option:nth-child("+($(this).index()+2)+")").attr("selected" , true);
        
        // $(this).parents(".attribute_section").siblings().each(function(index , value){
        //     attributes_ids.push($(value).find("select").attr("attribute_id"))
        // })

        // console.log($(this).parents('ul').siblings("select").find("option:nth-child("+($(this).index()+2)+")").val())

        next = $(this).parents(".attribute_section").next()
        if(next.length > 0){
            next.find("select").attr("attribute_id")
            get_attribute_options($(this).parents('ul').siblings("select").attr("attribute_id") , $(this).parents('ul').siblings("select").val() , next.find("select").attr("attribute_id") , $("input#product_id").val())
            
        }
        variations = []
        setTimeout(()=>{
            $(".product_variations select").each(function(index , value){
                // val += $(value).attr("attribute_id")+":"+$(value).val()
                input_variation = $("form.products_add_to_cart input[attribute_id='"+$(value).attr("attribute_id")+"']")
                input_variation.val($(value).attr("attribute_id")+":"+$(value).val())
                // console.log(input_variation.val())
                variations.push(input_variation.val())
            })
        } , 500)

        setTimeout(()=>{
            get_product_variation_price(variations , $("input#product_id").val())
        } , 500)

       
    })

    $($(".product_variations .attribute_section:first-child ul li.var_option.active")[0]).trigger("click")
   


})
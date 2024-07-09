

function construct_variables_options(select,data){
    select.html("")
    var selected = ""
    container = $("<select class='form-control' name='attributes[]' id='' size='5' multiple></select>");
    select.html(container)

    data.forEach((attribute) => {
        selected = (attribute.product) ? "selected" : ""
        option=$("<option value='"+attribute.attribute_id+"' "+selected+">"+attribute.name+"</option>")
        container.append(option)
    });
    
}


$(document).ready(function(){
    $("select#product_nature").change(function(){
        attr_section = $("#p-attributes")
        variation_section = $("#p-variations")
        parent_variable = $("#variable_parent")

        switch ($(this).val()) {

            case "Variable":
                $.get(base_url+"/supercontrol/variations/retrieve_product_attributes/"+$("input[name='product_id']").val() , function(data){
                    console.log(JSON.parse(data))

                    construct_variables_options(attr_section.find("div.attributes_container") , JSON.parse(data))
                    variation_section.hide()
                    parent_variable.hide()
                    attr_section.show()

                })

            break;

            case "Variation":
            attr_section.hide()
            parent_variable.show()
            parent_variable.find("select").siblings("div").css({"width" : "100%"})
            variation_section.show()

            break;

            default:
                attr_section.hide()
                variation_section.hide()
                parent_variable.hide()

            break;
        
        
        }
        
    })

    $("#variable_parent").on("change", "select.parent_variable" , function(){

        $.get(base_url+"/supercontrol/variations/retrieve_p_attribute_variations/"+$(this).val() , function(data){
            console.log(JSON.parse(data)["error"])
            variation_section = $("#p-variations")
            data = JSON.parse(data)
            if(data["error"]){
                // alert(data["message"])
                variation_section.find(".variations_container").html(data["message"])
            }

            else{
                variation_section.find(".variations_container").html(data["content"])
            }
        })
    })
    
    
    $(".album").on("mouseover" ,".element" , function(){
        $(this).find(".img_ctrl").slideDown(200)

    })
    $(".album").on("mouseleave" ,".element" , function(){
        $(this).find(".img_ctrl").slideUp(200)

    })

    // Delete an uploaded image
    $(".album").on("click" , ".img_ctrl .del_btn" , function(){
        image = $(this).parents(".element").find("img").attr("data")
        if(confirm("Are you sure to delete "+image+" ?")){
            $.ajax({
                url : base_url+"/supercontrol/products/delete_uploaded_image",
                method : "POST",
                data : {file_name : image},
                success : (data) => {
                    data = JSON.parse(data)["success"]
                    if(data == 1){
                        $(this).parents(".element").fadeOut(500)
                        $(this).parents(".element").remove()
                    }
                    
                },
                error : (jqXHR, textStatus, errorThrown)=>{

                }
            })
        }

    })

    // search for a file
    $("input.search_image").keyup(function(event , offset=0 , append=false){
        keyword = $(this).val()
        
            $.ajax({
                url : base_url+"/supercontrol/products/search_uploaded_images",
                method : "POST",
                data : {
                    keyword : keyword,
                    offset : offset
                },
                success : (data) => {
                    if($.trim(data) !== ""){
                        if(!append)
                        $(".album").html(data)
                        else $(".album").append(data)
                        count = $(".album").children(".element").length   
                        $(".album").attr("data-count",count)     
                    }
                          
                },
                error : (jqXHR, textStatus, errorThrown)=>{

                }
            })
      
    })

    // search more on scrol
    $(".album").scroll(function(){
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){

            $("input.search_image").trigger("keyup" , [$(".album").attr("data-count") , true])
        }
    })

    // initiate the files list
    if($("input.search_image").length > 0){
        keyword = $("input.search_image").val()
        $("input.search_image").trigger("keyup" , [$(".album").attr("data-count") , false])
    //     $.ajax({
    //     url : "http://192.168.2.177/supercontrol/products/search_uploaded_images",
    //         method : "POST",
    //         data : {
    //             keyword : keyword,
    //         },
    //         success : (data) => {
    //             $(".album").html(data)
    //             count = $(".album").children(".element").length   
    //             $(".album").attr("data-count",count)                    
    //         },
    //         error : (jqXHR, textStatus, errorThrown)=>{
    //         }
    // })
    }



})



function ws_confirm_operation(element){
  console.log(element)
  var href = element.attr('href');
  // Show a confirmation dialog
  if (confirm('Are you sure you want to proceed?')) {
      window.location.href = href;
  }
}

$(document).ready(function(){
  // Functions

    // add option group 
    function add_option_group(element){
      groups = element.parents("#bundle_opt_sec").children(".opt_group_container")
      groups.each(function(element , index){
        $(element).find("input[type='text']").attr("name" , "bundle_opt["+(index-1)+"][]")
        $(element).find("input[type='number']").attr("name" , "additional_price["+(index-1)+"][]")
      })
      parent=element.parents(".opt_group_container")
      new_group=parent.clone()

      new_group.find("input[type='text']").attr("name" , "bundle_opt["+(groups.length)+"][]")
      new_group.find("input[type='number']").attr("name" , "additional_price["+(groups.length)+"][]")

      new_group.find(".add_opt_group").addClass("remove_opt_group").removeClass("add_opt_group")
      new_group.find(".remove_opt_group").children(".fa-plus").remove()
      e=new_group.find(".remove_opt_group p").html('Remove group')

      element.parents("#bundle_opt_sec").append(new_group)
    }
  // Functions End

  
    $("#pr_list").on('change', ".edit_stock_qty", function () { 
        //Code 
       
        $.ajax({
            type: 'post',
            // url: base_url+'supercontrol/Products/yahia',
            url: base_url+'/supercontrol/Products/yahia',
            data: {
            'flag':"edit_stock",
            'stock_qty':$(this).val(),
            'product_id':$(this).attr("p_id")
            },
            success: function(data1){
              d=JSON.parse(data1)
              console.log(d)
              if(d.length > 0)
              alert(d[0])             
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
            }
          }); 
    });
    
    // precedence edit
    $("#pr_list").on('change', "input.edit_precedence", function () { 
      //Code 
      $.ajax({
          type: 'post',
          // url: base_url+'supercontrol/Products/yahia',
          url: base_url+'supercontrol/Products/yahia',
          data: {
          'flag':"edit_precedence",
          'precedence':$(this).val(),
          'product_id':$(this).attr("p_id")
          },
          success: function(data1){
            d=JSON.parse(data1)
            console.log(d)
            if(d.length > 0)
            alert(d[0])             
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
          }
        }); 
  });

    // edit set as new
    $("#pr_list").on('change', "select.edit_set_as_new", function () { 
      //Code
      $.ajax({
          type: 'post',
          // url: base_url+'supercontrol/Products/yahia',
          url: base_url+'supercontrol/Products/yahia',
          data: {
          'flag':"edit_set_as_new",
          'set_as_new':$(this).val(),
          'product_id':$(this).attr("p_id")
          },
          success: function(data1){
            d=JSON.parse(data1)
            console.log(d)
            if(d.length > 0)
            alert(d[0])             
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
          }
      }); 
  });
  
  
  // add products options

    $("#bundle_opt_sec").on("click",".add_opt",function(){
        parent=$(this).parent(".add_opt_container")
        new_opt=parent.clone()
        new_opt.find(".add_opt").addClass("remove_opt").removeClass("add_opt")
        new_opt.find(".remove_opt").children(".fa-plus").remove()
        e=new_opt.find(".remove_opt p").html('Remove option')
        console.log(new_opt)
        $(this).parents(".opt_group").append(new_opt)

    })

    

    $("#bundle_opt_sec").on("click" , ".add_opt_group" , function(){
      add_option_group($(this))
    })

    $("#bundle_opt_sec").on("click",".remove_opt",function(){
        $(this).parent(".add_opt_container").remove()
    })

    $("#bundle_opt_sec").on("click",".remove_opt_group",function(){
      $(this).parents(".opt_group_container").remove()
  })


    
    
    
    // event in the add newsletter section
    function add_nlsection_img(container,position){
      img_elem=
      '<div class="row">'+
        '<div class="form-group row col-lg-6 col-sm-12">'+
          '<label for="input-2" class="col-sm-3 col-form-label">Image '+position+'</label>'+
          '<div class="col-sm-12 col-lg-9">'+
              '<input id="files" type="file" name="image'+position+'" class="form-control">'+
              '<span class="pip">'+
                '<img class="imageThumb" src="" title="undefined"><br>'+
              '</span>'+
          '</div>'+
        '</div>'+
        '<div class="form-group row col-lg-6 col-sm-12">'+
            '<label for="input-1" class="col-lg-auto col-sm-12 col-form-label">Link'+position+'</label>'+
            '<div class="col-sm-12 col-lg-9">'+
                '<input type="text" class="form-control" name="link_'+position+'" value="">'+
            '</div>'+
        '</div>'+
      '</div>'
      container.append(img_elem);
      // return img_elem
    }

    $("select#nl_section_type").on("change", function(){



      // // alert($(this).val())
      // console.log($(this).parents("form").find("div.nl_image_content"))
      image_container=$(this).parents("form").find("div.nl_image_content")
      container=$(this).parents(".new_nl_section")
      section_id=container.attr("section_id")

      // $.ajax({
      //   type: "GET",
      //   url: "http://192.168.2.150/codeigniter/supercontrol/newsletter/get_sectionimages/"+section_id,
      //   success: function(data){
      //     console.log(JSON.parse(data)["image_1"])
      //   }
      // });
      image_container.children().remove()
      switch ($(this).val()) {
          case "MOSAIC":
            for(position=2 ; position <=4 ; position++){
              add_nlsection_img(image_container,position)
            }
          break;

          case "SUNGLASSES":
            for(position=2 ; position <=2 ; position++){
              add_nlsection_img(image_container,position)
            }
          break;
      
          default:
            image_container.children().remove()
          break;
      }
        
      
    })


    $(".new_nl_section input[type=file]").on("change",function(){
      $(this).siblings(".pip").children().remove()
    })
    
    $("#offer_end_date,#offer_start_date").datetimepicker({});
    $("#valid_from,#valid_until,#new_from,#new_until").datetimepicker({});

    // Set as product as new with date range
    $("select[name='set_as_new']").change(function(){
      switch ($(this).val()) {
        case "Yes":
          $("div.set_as_new_date_range").show()
          break;
      
        default:
          $("div.set_as_new_date_range").hide()

          break;
      }
    }) 

})


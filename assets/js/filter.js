function getsearchdata(loadmore = false , sort = ''){
    if(sort.trim() !== '')
    $("#short").val(sort);
// COLLECT
    if(loadmore)
    $("#currentPage").val(parseInt(document.getElementById('currentPage').value )+ 1);
    else
    $("#currentPage").val(1);

    var page= $("#currentPage").val();

    var selected = new Array();
    $("input:checkbox[name=brand]:checked").each(function() {
      selected.push($(this).val());
    });

    var color=[]; 
    $('input[name=color]:checked').each(function(){
      color.push($(this).val());
    });

    var brand=[]; 
    $('input[name=brand]:checked').each(function(){
      brand.push($(this).val());
    });
    
     var preOrder=[]; 
    $('input[name=preOrder]:checked').each(function(){
      preOrder.push($(this).val());
    });
    
    var freebie=[]; 
    $('input[name=freebie]:checked').each(function(){
      freebie.push($(this).val());
    });
    
    var evergreen=[]; 
    $('input[name=evergreen]:checked').each(function(){
      evergreen.push($(this).val());
    });
    
    var exclusive=[]; 
    $('input[name=exclusive]:checked').each(function(){
      exclusive.push($(this).val());
    });
    
     var type=[]; 
    $('input[name=type]:checked').each(function(){
      type.push($(this).val());
    });
    
    var categoryList=[]; 
    $('input[name=categoryList]:checked').each(function(){
      categoryList.push($(this).val());
    });
    
    var suitablefor=[]; 
    $('input[name=suitable_for]:checked').each(function(){
      suitablefor.push($(this).val());
    });

    var regions=[]; 
    $('input[name=regions]:checked').each(function(){
      regions.push($(this).val());
    });

    var age=[]; 
    $('input[name=age]:checked').each(function(){
      age.push($(this).val());
    });

    var offer=[]; 
    $('input[name=offer]:checked').each(function(){
      offer.push($(this).val());
    });   

    var new_realesed=[]; 
    $('input[name=new_realesed]:checked').each(function(){
      new_realesed.push($(this).val());
    });

    var stock_status=[]; 
    $('input[name=stock_status]:checked').each(function(){
      stock_status.push($(this).val());
    });

    var ws_search_category = ($("input[name='ws-search-category']").length > 0) ? $("input[name='ws-search-category']").val() : null;
// END COLLECT

    $(document).ready(function(){
        if(!loadmore)
        $("#Jagat-datatable").html(""); 
        $("#loading").show(); 
        $.ajax({
          type: 'post',
          url: base_url+'page/getSearchData',
          data: {
            'sort':$("#short").val(), 
            'showOffer':$("#showOffer").val(),
            'offer_cdn':$("#offer_cdn").val(),
            'preOrder':preOrder, 
            'freebie':freebie,
            'evergreen':evergreen,
            'exclusive':exclusive,
            'priceupto':$("#myRange").val(), 
            'brand':brand,
            'type':type,
            'categoryList':categoryList,
            'keyword':$("#keyword").val(),
            'age':age, 
            'suitable_for':suitablefor,
            'regions':regions,
            'master_category':$("#master_category").val(),
            'color':color,'page':page,
            'offer':offer,
            'new_realesed':new_realesed,
            'stock_status':stock_status,
            'page':page,
            'ws-search-category':ws_search_category,
          },
          success: function(data1){

            $("#loading").hide();
            if(loadmore){
                $("#Jagat-datatable").append(data1).fadeIn(5000);
      
                var numItems = $('#Jagat-datatable').children('.col-md-3').length;
                $("#pgCount").html(numItems);
                $("#pgCount2").html(numItems);

                if(numItems==$("#ofPrduct").html()){
                   $("#LoadMore").hide();
                }
            }
            else{
                $("#Jagat-datatable").html(data1);
                if($("#totalProducts").val() < 53){
                    $("#LoadMore").hide();
                    $("#pageingation").hide();
                    $("#pgCount2").html($("#totalProducts").val());
                }
                else{
                     $("#pgCount2").html(52);
                     $("#LoadMore").show();
                      // $("#pageingation").show();
                     $("#ofPrduct").html($("#totalProducts").val());
                }
            }

          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
          }
        });
    })
}

// Sort By
function sortby(v){
    getsearchdata(false , v)
}
// Sort By

$(document).ready(function(){
    // Load Data Grid
    if(is_product_list_page){
        getsearchdata()
    }
    // Load Data Grid

    // Load More
    $(document).on('click ','#LoadMore',function(){
        getsearchdata(true)
    })
    // Load More

    // Filter change
    $(".JagatFilterInput").change(function(){
        getsearchdata()
    })
    // Filter change
})


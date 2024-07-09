function submitPackageForm(pid) {
    $(".packageForm"+pid).submit();
}

function forgotPassword() {
    $("#buyer_login_form").hide();
    $("#ForgotForm").show();
    $("#LoginUsingEmial").html("-- Forgot Password --");
}


function forgotPassword2() {
    $("#buyer_login_form2").hide();
    $("#ForgotForm2").show();
    $("#LoginUsingEmial2").html("-- Forgot Password --");
     $('#ForgotForm2').trigger("reset");
      $('#ForgotForm2').focus();
     
}


$(document).on('click', '#ApplyCoupon', function(e){
    $("#loading").show();
    var cd=$("#coupon_code").val();
    if(cd){
       $.ajax({
    type: 'Post',
    url: base_url+"/page/applyCouponCode",
    data: {'coupon_code':cd},
    success: function(data1){
      //console.log(data1);
      var obj = JSON.parse(data1);
      if( obj['action']=="success"){
          
         location.reload();
      }else{ $("#loading").hide();
        $("#toastfailure").html(' '+obj['msg']); 
        $("#toastfailure").fadeIn().delay(2000).fadeOut();
      }
//   $(".shopping-cart").html(data);
},
error: function(jqXHR, textStatus, errorThrown) {  
}
});    
    }else{
        alert('Enter Coupon code!');
    }
});

function sortby(v) {
    
    $("#short").val(v);
    
     $(document).ready(function(){
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
    var age=[]; 
    $('input[name=age]:checked').each(function(){
      age.push($(this).val());
    });
    var offer=[]; 
    $('input[name=offer]:checked').each(function(){
      offer.push($(this).val());
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
    
    
    
    $("#Jagat-datatable").html(""); 
    $("#loading").show(); 
    $.ajax({
      type: 'post',
      url: base_url+'page/getSearchData',
      data: {
        'sort':v, 
        'showOffer':$("#showOffer").val(),
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
        'master_category':$("#master_category").val(),
        'color':color,'page':page,
        'offer':offer
      },
      success: function(data1){
        //console.log(data1);
        $("#loading").hide();
        $("#Jagat-datatable").html(data1);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
      }
    });    }); 
}

function addToWishlist(pid,pname,pimage) {
    
  $.ajax({
    type: 'Post',
    url: base_url+"/page/addWishtlist",
    data: {'product_id':pid},
    success: function(data1){
      //console.log(data1);
      var obj = JSON.parse(data1);
      if( obj['action']=="Add to wishlist"){
          
          
        $("#cart-heading").html(pname);
        $("#cart-para").html(' '+obj['msg']);
        $("#cart-img").attr("src",base_url+"/assets/uploads/"+pimage); 
        $(".show_indesktop").fadeIn().delay(2000).fadeOut('slow'); 
        
        $("."+pid).toggleClass( "active" );
        
      }else{
        $("#toastfailure").html(' '+obj['msg']); 
        $("#toastfailure").fadeIn().delay(2000).fadeOut();
      }
//   $(".shopping-cart").html(data);
},
error: function(jqXHR, textStatus, errorThrown) {  
}
}); 
}
function showBuyerSignupForm() {
  document.getElementById("buyer_signup_section").style.display = "block";
  document.getElementById("buyer_login_form_section").style.display = "none";
}
function showBuyerLoginFOrm() {
  document.getElementById("buyer_signup_section").style.display = "none";
  document.getElementById("buyer_login_form_section").style.display = "block";
}
$(document).on('submit', '#buyer_signup_formGuest', function(e){
  e.preventDefault();
  var frm = $('#buyer_signup_formGuest');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#buyer_signup_messageGuest').show();
        $('#buyer_signup_messageGuest').html(obj[1]);
        document.getElementById('buyer_signup_messageGuest').scrollIntoView(true);
      }else{
        $('#buyer_signup_messageGuest').show();
        $('#buyer_signup_messageGuest').html(obj[1]);
        $('#buyer_signup_form').trigger("reset");
        document.getElementById('buyer_signup_messageGuest').scrollIntoView(true); location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#buyer_signup_messageGuest').show();
      $('#buyer_signup_messageGuest').html(textStatus);
      document.getElementById('buyer_signup_messageGuest').scrollIntoView(true);
    }
  });
});
$(document).on('submit', '#buyer_signup_form2', function(e){
  e.preventDefault();
  var frm = $('#buyer_signup_form2');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){
        
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#buyer_signup_message2').show();
        $('#buyer_signup_message2').html(obj[1]);
        document.getElementById('buyer_signup_message2').scrollIntoView(true);
      }else{
        $('#buyer_signup_message2').show();
        $('#buyer_signup_message2').html(obj[1]);
        $('#buyer_signup_form2').trigger("reset");
        document.getElementById('buyer_signup_message2').scrollIntoView(true);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#buyer_signup_message2').show();
      $('#buyer_signup_message2').html(textStatus);
      document.getElementById('buyer_signup_message2').scrollIntoView(true);
    }
  });
});

$(document).on('submit', '#loginWithOTP2', function(e){
  e.preventDefault();
  var frm = $('#loginWithOTP2');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#loginWithOTPMssage2').show();
        $('#loginWithOTPMssage2').html(obj[1]);
      }else{
          
           $('#vphone2').val( $('#pn2').val());
          
        $('#loginWithOTPMssage2').show();
        $('#loginWithOTPMssage2').html(obj[1]);
       $("#loginWithOTP2").hide();
        $("#verifyOTP2").show();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#loginWithOTPMssage2').show();
      $('#loginWithOTPMssage2').html(textStatus);
    }
  });
}); 




$(document).on('submit', '#loginWithOTP', function(e){
  e.preventDefault();
  var frm = $('#loginWithOTP');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#loginWithOTPMssage').show();
        $('#loginWithOTPMssage').html(obj[1]);
      }else{
          
           $('#vphone').val( $('#pn').val());
          
        $('#loginWithOTPMssage').show();
        $('#loginWithOTPMssage').html(obj[1]);
       $("#loginWithOTP").hide();
        $("#verifyOTP").show();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#loginWithOTPMssage').show();
      $('#loginWithOTPMssage').html(textStatus);
    }
  });
}); 




$(document).on('submit', '#verifyOTP', function(e){
  e.preventDefault();
  var frm = $('#verifyOTP');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#loginWithOTPMssage').show();
        $('#loginWithOTPMssage').html(obj[1]);
      }else{
        $('#loginWithOTPMssage').show();
        $('#loginWithOTPMssage').html(obj[1]);
       
         location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#loginWithOTPMssage').show();
      $('#loginWithOTPMssage').html(textStatus);
    }
  });
}); 



$(document).on('submit', '#verifyOTP2', function(e){
  e.preventDefault();
  var frm = $('#verifyOTP2');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#loginWithOTPMssage2').show();
        $('#loginWithOTPMssage2').html(obj[1]);
      }else{
        $('#loginWithOTPMssage2').show();
        $('#loginWithOTPMssage2').html(obj[1]);
       
         location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#loginWithOTPMssage2').show();
      $('#loginWithOTPMssage2').html(textStatus);
    }
  });
}); 



$(document).on('submit', '#buyer_login_form2', function(e){
  e.preventDefault();
  var frm = $('#buyer_login_form2');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#buyer_login_form_message2').show();
        $('#buyer_login_form_message2').html(obj[1]);
      }else{
        $('#buyer_login_form_message2').show();
        $('#buyer_login_form_message2').html(obj[1]);
        $('#signupForm').trigger("reset");
        location.reload();
//   window.location.href = baseurl + 'profile/dashboard';
}
},
error: function(jqXHR, textStatus, errorThrown) {  
  $('#buyer_login_form_message2').show();
  $('#buyer_login_form_message2').html(textStatus);
}
});
}); 
$(document).on('submit', '#buyer_signup_form', function(e){
  e.preventDefault();
  var frm = $('#buyer_signup_form');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#buyer_signup_message').show();
        $('#buyer_signup_message').html(obj[1]);
        document.getElementById('buyer_signup_message').scrollIntoView(true);
      }else{
        $('#buyer_signup_message').show();
        $('#buyer_signup_message').html(obj[1]);
        $('#buyer_signup_form').trigger("reset");
        document.getElementById('buyer_signup_message').scrollIntoView(true);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {  
      $('#buyer_signup_message').show();
      $('#buyer_signup_message').html(textStatus);
      document.getElementById('buyer_signup_message').scrollIntoView(true);
    }
  });
});



$(document).on('submit', '#ForgotForm2', function(e){
  e.preventDefault();
  var frm = $('#ForgotForm2');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#ForgotMessage2').show();
        $('#ForgotMessage2').html(obj[1]);
      }else{
        $('#ForgotMessage2').show();
        $('#ForgotMessage2').html(obj[1]);
        $('#ForgotForm2').trigger("reset");
        // location.reload();
//   window.location.href = baseurl + 'profile/dashboard';
}
},
error: function(jqXHR, textStatus, errorThrown) {  
  $('#ForgotMessage2').show();
  $('#ForgotMessage2').html(textStatus);
}
});
}); 



$(document).on('submit', '#ForgotForm', function(e){
  e.preventDefault();
  var frm = $('#ForgotForm');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#ForgotMessage').show();
        $('#ForgotMessage').html(obj[1]);
      }else{
        $('#ForgotMessage').show();
        $('#ForgotMessage').html(obj[1]);
        $('#signupForm').trigger("reset");
        // location.reload();
//   window.location.href = baseurl + 'profile/dashboard';
}
},
error: function(jqXHR, textStatus, errorThrown) {  
  $('#ForgotMessage').show();
  $('#ForgotMessage').html(textStatus);
}
});
}); 





$(document).on('submit', '#resetPasswordForm', function(e){
  e.preventDefault();
  var frm = $('#resetPasswordForm');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#resetPasswordMessage').show();
        $('#resetPasswordMessage').html(obj[1]);
      }else{
        $('#resetPasswordMessage').show();
        $('#resetPasswordMessage').html(obj[1]);
        $('#resetPasswordForm').trigger("reset");
         $('#resetPasswordForm').hide();
          $('#forgotLogin').show();
         
        
}
},
error: function(jqXHR, textStatus, errorThrown) {  
  $('#resetPasswordMessage').show();
  $('#resetPasswordMessage').html(textStatus);
}
});
}); 





$(document).on('submit', '#buyer_login_form', function(e){
  e.preventDefault();
  var frm = $('#buyer_login_form');
  var formData = frm.serialize();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: formData,
    success: function(data){ 
      var obj = jQuery.parseJSON(data);
      if( obj[0]=="error"){
        $('#buyer_login_form_message').show();
        $('#buyer_login_form_message').html(obj[1]);
      }else{
        $('#buyer_login_form_message').show();
        $('#buyer_login_form_message').html(obj[1]);
        $('#signupForm').trigger("reset");
        location.reload();
//   window.location.href = baseurl + 'profile/dashboard';
}
},
error: function(jqXHR, textStatus, errorThrown) {  
  $('#buyer_login_form_message').show();
  $('#buyer_login_form_message').html(textStatus);
}
});
}); 
$(document).ready(function(){
  $('.add').click(function () {
    $("#plusHit").val(parseInt($("#plusHit").val())+1);
    var incr=parseFloat($("#incr").val());
//    if ($(this).prev().val() < 3) {
  $(this).prev().val(+$(this).prev().val() + incr);
//    }
});
  $('.sub').click(function () {
    var incr=parseFloat($("#incr").val());
    var lotpr=parseFloat($("#lotpr").val());
    if ($(this).next().val() > lotpr) {
      if ($(this).next().val() > lotpr) $(this).next().val(+$(this).next().val() - incr);
    }
  });
//   $('[data-toggle="tooltip"]').tooltip();
}); 
$(document).on('click','#cart', function(e){
  e.preventDefault();
  $(".shopping-cart").fadeToggle( "fast");
});
$(document).on('submit','.buy-now-form', function(e){
  e.preventDefault();
  var formData = $(this).serialize();
  var fdata = $(this).serializeArray();
  var p=fdata[0].value;
  var i=fdata[1].value;
  $.ajax({
    type: $(this).attr('method'),
    url: $(this).attr('action'),
    data: formData,
    success: function(data1){ 
      //console.log(data1);
      var obj = JSON.parse(data1);
      if( obj['action']=="Add to cart"){
        $("#cart-heading").html(p);
        $("#cart-para").html("Item successfully added to your cart");
        $("#cart-img").attr("src",base_url+"/assets/uploads/"+i); 
        $(".show_indesktop").fadeIn().delay(2000).fadeOut('slow'); 
        $(".counter_cart").html(obj['value']);
/*      $("#toast").html(' <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z" fill="rgba(16,188,89,1)"/></svg>'+obj['msg']); 
$("#toast").fadeIn().delay(2000).fadeOut();*/
}else{
  $("#toast").html(' <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z" fill="rgba(16,188,89,1)"/></svg>'+obj['msg']); 
  $("#toast").fadeIn().delay(2000).fadeOut();
}
//   $(".shopping-cart").html(data);
},
error: function(jqXHR, textStatus, errorThrown) {
  $("#toast").fadeIn();
}
});
});
$(document).on('submit','.addWishlist', function(e){
  e.preventDefault();
  var formData = $(this).serialize();
  $.ajax({
    type: $(this).attr('method'),
    url: $(this).attr('action'),
    data: formData,
    success: function(data){
      var obj = jQuery.parseJSON(data);
      if(obj['action']=="Add to wishlist"){
        $("#toast").html(obj['msg']); 
        $("#toast").fadeIn().delay(2000).fadeOut();
      }else{
        $("#toastfailure").html(obj['msg']); 
        $("#toastfailure").fadeIn().delay(2000).fadeOut(); 
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $("#toast").fadeIn();
    }
  });
});
$('.shop_by_category').click(function(){
  $('.show_by_category_dropdown').toggle();
});
$(document).ready(function(){
  $("#attributesGroup").change(function(){ 
    $.ajax({
      type: 'post',
      url: base_url+'page/getAttributes',
      data: {
        'pid':$("#pid").val(), 
        'attributesGroup':$("#attributesGroup").val() 
      },
      success: function(data1){ 
        //console.log(data1);
        $("#attributes").html(data1);
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    }); 
  }); 
//   $('.gallery_open_1').lightGallery();
});
 
 // Load more start
$(document).on('click ','#LoadMore',function(){
    
    $("#currentPage").val(parseInt(document.getElementById('currentPage').value )+ 1);
    
    
   var page= $("#currentPage").val();
   
//   ####################
 
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
    var age=[]; 
    $('input[name=age]:checked').each(function(){
      age.push($(this).val());
    });
    var offer=[]; 
    $('input[name=offer]:checked').each(function(){
      offer.push($(this).val());
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
    
    
    
    
    
    
    
    
    
    
    
    // $("#Jagat-datatable").html(""); 
    $("#loading2").show(); 
    $.ajax({
      type: 'post',
      url: base_url+'page/getSearchData',
      data: {
        'sort':$("#short").val(), 
        'showOffer':$("#showOffer").val(),
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
        'master_category':$("#master_category").val(),
        'color':color,
        'page':page,
        'offer':offer
      },
      success: function(data1){
        //console.log(data1);
        $("#loading2").hide();
        $("#Jagat-datatable").append(data1).fadeIn(5000);
        
        var numItems = $('#Jagat-datatable').children('.col-md-3').length;
        $("#pgCount").html(numItems);
         $("#pgCount2").html(numItems);
         
         if(numItems==$("#ofPrduct").html()){
             $("#LoadMore").hide();
         }
         
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
      }
    }); 
// #################
});

  // END load more END
   

$(document).ready(function() {
    
    
      // wallet start
$('#wallet_use').click(function(){
  if($(this).is(":checked")){
    var wallet_bal=$("#wallet_bal").val();
    var checkout_total=$("#checkout_total").val();
    var payable=checkout_total;
    var netp=0;
    if(parseFloat(wallet_bal) >= parseFloat(checkout_total)){
       payable=checkout_total;
       netp=0;
    }else{
        payable=wallet_bal;
        netp= (checkout_total)- (wallet_bal);
    }
    
    var html='  <div class="col-auto"> Wallet used </div>   <div class="col-auto"> - '+payable+' AED</div>   ';
    $("#wallet_section").html(html);
    
     var html='  <div class="col-auto"> Payable </div>   <div class="col-auto">'+netp.toFixed(2)+' AED</div>   ';
    $("#payable_section").html(html);
    
    
    
            
  }
  else if($(this).is(":not(:checked)")){
    $("#wallet_section").html('');
     $("#payable_section").html('');
  }
});
    // wallet end
   
    
   
   
    
  $(".JagatFilterInput").change(function(){ 
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
    var age=[]; 
    $('input[name=age]:checked').each(function(){
      age.push($(this).val());
    });
    var offer=[]; 
    $('input[name=offer]:checked').each(function(){
      offer.push($(this).val());
    });   
    $("#Jagat-datatable").html(""); 
    $("#loading").show(); 
    $.ajax({
      type: 'post',
      url: base_url+'page/getSearchData',
      data: {
        'sort':$("#sort").val(),
        'showOffer':$("#showOffer").val(),
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
        'master_category':$("#master_category").val(),
        'color':color,'page':page,
        'offer':offer
      },
      success: function(data1){
        //console.log(data1);
        $("#loading").hide();
        $("#Jagat-datatable").html(data1);
       if($("#totalProducts").val() <= 8){
            $("#LoadMore").hide();
              $("#pageingation").hide();
            
        }else{
             $("#LoadMore").show();
              $("#pageingation").show();
             $("#ofPrduct").html($("#totalProducts").val());
             
             
        }
        
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
      }
    }); 
  });  
  if (uri1=="product-list") { 
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
    
    
     var categoryList=[]; 
    $('input[name=categoryList]:checked').each(function(){
      categoryList.push($(this).val());
    });
    
     var type=[]; 
    $('input[name=type]:checked').each(function(){
      type.push($(this).val());
    });
    
    
    var suitablefor=[]; 
    $('input[name=suitable_for]:checked').each(function(){
      suitablefor.push($(this).val());
    });
    var age=[]; 
    $('input[name=age]:checked').each(function(){
      age.push($(this).val());
    });
    var offer=[]; 
    $('input[name=offer]:checked').each(function(){
      offer.push($(this).val());
    });
    $("#Jagat-datatable").html(""); 
    $("#loading").show(); 
    $.ajax({
      type: 'post',
      url: base_url+'page/getSearchData',
      data: {
        'sort':$("#sort").val(), 
         'showOffer':$("#showOffer").val(),
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
        'master_category':$("#master_category").val(),
        'color':color,'page':page,
        'offer':offer
      },
      success: function(data1){
        //console.log(data1);
        $("#loading").hide();
        $("#Jagat-datatable").html(data1);
       if($("#totalProducts").val() <= 52){
            $("#LoadMore").hide();
              $("#pageingation").hide();
              
            
            
                 
            
                  $("#pgCount2").html($("#totalProducts").val());
           
              
              
            
        }else{
             $("#pgCount2").html(52);
             $("#LoadMore").show();
              $("#pageingation").show();
             $("#ofPrduct").html($("#totalProducts").val());
        }
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('#signupError').html(textStatus).delay(2000).fadeOut(2000);
      }
    }); 
  }
}); 
$(document).ready(function() { 
  $('#makeJagat').on('change',function(){ 
    var countryID = $("#makeJagat").val();
    if(countryID){
      $.ajax({
        type:'POST',
        url:baseurl+'supercontrol/home/getModel',
        data:'country_id='+countryID,
        success:function(data){ 
          $('#modelJagat').html(data);
        }
      }); 
    }
  });
});
/*
function showBuyerSignupForm() {
document.getElementById("buyer_signup_section").style.display = "block";
document.getElementById("buyer_login_form_section").style.display = "none";
}
function showBuyerLoginFOrm() {
document.getElementById("buyer_signup_section").style.display = "none";
document.getElementById("buyer_login_form_section").style.display = "block";
}
$(document).on('submit', '#buyer_signup_form', function(e){
e.preventDefault();
var frm = $('#buyer_signup_form');
var formData = frm.serialize();
$.ajax({
type: frm.attr('method'),
url: frm.attr('action'),
data: formData,
success: function(data){
var obj = jQuery.parseJSON(data);
if( obj[0]=="error"){
$('#buyer_signup_message').show();
$('#buyer_signup_message').html(obj[1]);
document.getElementById('buyer_signup_message').scrollIntoView(true);
}else{
$('#buyer_signup_message').show();
$('#buyer_signup_message').html(obj[1]);
$('#buyer_signup_form').trigger("reset");
document.getElementById('buyer_signup_message').scrollIntoView(true);
}
},
error: function(jqXHR, textStatus, errorThrown) {  
$('#buyer_signup_message').show();
$('#buyer_signup_message').html(textStatus);
document.getElementById('buyer_signup_message').scrollIntoView(true);
}
});
});
$(document).on('submit', '#buyer_login_form', function(e){
e.preventDefault();
var frm = $('#buyer_login_form');
var formData = frm.serialize();
$.ajax({
type: frm.attr('method'),
url: frm.attr('action'),
data: formData,
success: function(data){ 
var obj = jQuery.parseJSON(data);
if( obj[0]=="error"){
$('#buyer_login_form_message').show();
$('#buyer_login_form_message').html(obj[1]);
}else{
$('#buyer_login_form_message').show();
$('#buyer_login_form_message').html(obj[1]);
$('#signupForm').trigger("reset");
location.reload();
//   window.location.href = baseurl + 'profile/dashboard';
}
},
error: function(jqXHR, textStatus, errorThrown) {  
$('#buyer_login_form_message').show();
$('#buyer_login_form_message').html(textStatus);
}
});
}); */
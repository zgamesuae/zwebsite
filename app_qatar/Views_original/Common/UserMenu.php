<?php  
$uri = service('uri'); 
 ;
$uri1=$uri2=$uri3="";
if(count(@$uri->getSegments())>0){
 
  $uri1=@$uri->getSegment(1); 
}
if(count(@$uri->getSegments())>1){
  $uri2=@$uri->getSegment(2); 
  
} 
if(count(@$uri->getSegments())>2){
 $uri3=@$uri->getSegment(3);   
} 
  ?>



    <div class="bg-white shadow-sm p-3 rounded">
            <div class="account_user_profile_left_side">
              <h4><strong>Account </strong></h4>
              <ul>
                  <a href="<?php echo base_url();?>/profile/" 
                  
                  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="") echo 'active';?>" 
                  ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/></svg> <span>Edit Profile</span></a>
                  
                  
                  
                  <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="changePassword") echo 'active';?>"  href="<?php echo base_url();?>/profile/changePassword" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976L12 1zm0 2.049L5 4.604v9.185a4 4 0 0 0 1.781 3.328L12 20.597l5.219-3.48A4 4 0 0 0 19 13.79V4.604L12 3.05zM12 7a2 2 0 0 1 1.001 3.732L13 15h-2v-4.268A2 2 0 0 1 12 7z"/></svg><span>Change Password</span></a>
                      <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="Wallet") echo 'active';?>"  href="<?php echo base_url();?>/profile/Wallet"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M22 7h1v10h-1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v3zm-2 10h-6a5 5 0 0 1 0-10h6V5H4v14h16v-2zm1-2V9h-7a3 3 0 0 0 0 6h7zm-7-4h3v2h-3v-2z"/></svg><span>My Wallet</span></a>
          
                  <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="wishlist") echo 'active';?>"  href="<?php echo base_url();?>/profile/wishlist"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg><span>My Wishlist</span></a>
                  <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="myOrders") echo 'active';?>"   href="<?php echo base_url();?>/profile/myOrders"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M6.5 2h11a1 1 0 0 1 .8.4L21 6v15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4zM19 8H5v12h14V8zm-.5-2L17 4H7L5.5 6h13zM9 10v2a3 3 0 0 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2h2z"/></svg><span>My Orders</span></a>
                  
                  
                        
                      
                      <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="addAddress") echo 'active';?>"   href="<?php echo base_url();?>/profile/addAddress"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 23.728l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zm4.95-7.778a7 7 0 1 0-9.9 0L12 20.9l4.95-4.95zM12 13a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg><span>Add Address</span></a>
                      
                       <a  class="<?php if(($uri1=="Profile" ||$uri1=="profile" ) && $uri2=="address") echo 'active';?>"   href="<?php echo base_url();?>/profile/address"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 23.728l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zm4.95-7.778a7 7 0 1 0-9.9 0L12 20.9l4.95-4.95zM12 13a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg><span>My Address</span></a>
                  
                    <a href="<?php echo base_url();?>/logout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2a9.985 9.985 0 0 1 8 4h-2.71a8 8 0 1 0 .001 12h2.71A9.985 9.985 0 0 1 12 22zm7-6v-3h-8v-2h8V8l5 4-5 4z"/></svg><span>Logout</span></a>
              </ul>
            </div>
          </div>
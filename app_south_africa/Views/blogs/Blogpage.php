  
<div class="container-fluid">
  
  <div class="ws-blogs row p-0">
      <?php echo view("blogs/Blogside" , ["blog_cats" => $cats , "blogpage" => ($blog && isset($blog) && sizeof($blog) ? true : false) ]); ?>
      <?php
        if($blogs && isset($blogs) && $blogs && sizeof($blogs) > 0)
        echo view("blogs/Bcontent" , ["data" => $blogs]); 

        else if($blog && isset($blog) && sizeof($blog) > 0)
        echo view("BlogDetail", ["data" => [$blog , $related_blogs]]);

        else 
        echo "
        <div class='row col-sm-12 col-md-9 col-lg-10 p-0 px-3 h-100 p-5 m-0 justify-content-center text-center'>
          <p style='font-size: 1.5rem; color: #cfcfcf'> NO RESULTS FOUND </p> 
        </div> 
         "
        
      ?>
  </div>
</div>

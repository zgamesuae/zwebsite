<?php 
    $blogModel = model("App\Models\BlogModel");
    $userModel = model("App\Models\UserModel");
    $setting_req = "select * from settings";
    $settings = $userModel->customQuery($setting_req);
?>
<div class="col-sm-12 col-md-3 col-lg-2 p-0 m-0 ws-blog-side" style="background-color: #021629">
    <div class="row col-12 m-0">
        <!-- Side bare Heading -->
        <div class="row mx-0 justify-content-between align-items-center ws-blog-heading col-12 p-0 mt-4">
            <div class="col-3 col-md-4 p-0">
                <a href="<?php echo base_url() ?>">
                    <img class="logo" style="max-width: 100%" src="<?php echo base_url() ?>/assets/uploads/ZGames_550px_W.png" alt="<?php echo $settings[0]->business_name ?>">
                </a>
            </div>
            <div class="col-8 col-md-7 p-0">
                <?php if($blogpage): ?>
                    <h2 class="m-0 text-center" style="font-size: 2.1rem">BLOGS</h2>
                <?php else: ?>
                    <h1 class="m-0 text-center" style="font-size: 2.1rem">BLOGS</h1>
                <?php endif; ?>
            </div>

            <div class="col-12 p-0">
                <hr class="col-12 p-0" style="height: .5px; background: rgba(255, 255, 255, 0.2);">
            </div>
        </div>
        <!-- Side bare Heading -->

        <!-- Blog Categories -->
        <div class="col-12 row justify-content-start align-items-start m-0 p-0 ws-blog-cats">
            <ul class="m-0 p-0 col-12">

                <?php 
                    foreach($blog_cats as $cat): 
                    $selected = (isset($_GET["category"]) || isset($b_category)) && in_array($cat->id , [$_GET["category"] , $b_category]) || (isset($cat_slug) && $cat_slug == $cat->slug);
                ?>
                <li class="col-auto col-md-12 py-2 py-md-3 pl-3 ws-category-elem <?php if($selected) echo "selected"; ?>">
                    <a href="<?php echo $blogModel->blog_category_url($cat) ?>">
                        <span <?php if($cat->precedence==4) echo 'style="color: #ffd900;"' ?>><?php echo $cat->name ?></span>
                    </a>
                </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <!-- Blog Categories -->

    </div>
</div>
  
<?php
    $uri = service('uri');
    $ns = model("App\Models\NewsletterModel");
    $ns_instances=$ns->get_newsletters();

    if($validation){
        // var_dump($validation);die();
    }
    
?>

<style>
    .multi {
        height: 200px !important;
    }

    #editor {
        border: 1px solid #cacfe7;
        color: #3b4781;
    }

    input[type=file] {
        display: block
    }

    .imageThumb {
        height: 122px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid #000;
        color: #fff;
        text-align: center;
        cursor: pointer
    }

    .remove:hover {
        background: #fff;
        color: #000
    }
</style>



<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php include 'Common/Breadcrumb.php'; ?>
        <div class="content-body">
            
        <?php if($validation):?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Required field(s)</strong> 
          <?php foreach($validation as $value){
              echo($value);
          }
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php endif;?>

            <!-- Basic Tables start -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content  ">
                            <div class="card-body new_nl_section" <?php if(isset($section)):?> section_id="<?php echo($section[0]->id) ?>"<?php endif; ?>>
                                <form method="post" enctype="multipart/form-data">
                                            <!-- Select a newsletter -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">newsletter*</label>
                                                <div class="col-sm-9">
                                                    <select required class="form-control" name="n_id" required="">
                                                        <option value="">Select a newsletter</option>
                                                        <?php if(isset($ns_instances) && sizeof($ns_instances) > 0):
                                                            foreach($ns_instances as $instance):    
                                                        ?>
                                                            <option <?php if($section[0]->n_id == $instance->id) echo "selected"; ?> value="<?php echo $instance->id ?>"><?php echo $instance->subject ?></option>
                                                        <?php endforeach; endif; ?>
                                                    </select>

                                                </div>
                                            </div>

                                            <!-- Section title -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Section title*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="section_title" required value="<?php echo $section[0]->section_title; ?>">
                                                </div>
                                            </div>

                                            <!-- Sectiopn type -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Section type*</label>
                                                <div class="col-sm-9">
                                                    <select required class="form-control" id="nl_section_type" name="section_type" required="">
                                                        <option value="">Select a type</option>
                                                        <option <?php if($section[0]->section_type == "HORIZONTAL") echo "selected"; ?> value="HORIZONTAL">HORIZONTAL</option>
                                                        <option <?php if($section[0]->section_type == "MOSAIC") echo "selected"; ?> value="MOSAIC">MOSAIC</option>
                                                        <option <?php if($section[0]->section_type == "SUNGLASSES") echo "selected"; ?> value="SUNGLASSES">SUNGLASSES</option>
                                                        <option <?php if($section[0]->section_type == "BIG_SQUARE") echo "selected"; ?> value="BIG_SQUARE">BIG SQUARE</option>
                                                    </select>

                                                </div>
                                            </div>
                                            
                                            <!-- Section order -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Section order*</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="section_order" required="" value="<?php echo $section[0]->section_order; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <!-- static Image 1 -->
                                                <div class="form-group row col-lg-6 col-sm-12">
                                                    <label for="image1" class=" col-lg-3 col-sm-12 col-form-label">Image 1 </label>
                                                    <div class="col-sm-12 col-lg-9">
                                                        <input id="files" type="file" name="image1" class="form-control">
                                                                
                                                        <?php
                                                                $file_name = $section[0]->image_1;
                                                                $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                                                if ($extension == "mp4")
                                                                {
                                                        ?>

                                                        <span class="pip">
                                                            <video width="150" height="150" controls>
                                                                <source
                                                                    src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" type="video/mp4">
                                                            </video>
                                                            <br><a
                                                                href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a>
                                                        </span>
                                                                
                                                        <?php
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                        <span class="pip">
                                                            <img class="imageThumb" src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" title="undefined"><br>
                                                            <!-- <a href="<?php echo base_url(); ?>/supercontrol/newsletter/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a> -->
                                                        </span>
                                                                
                                                                
                                                        <?php
                                                                }
                                                        ?>

                                                    </div>
                                                </div>

                                                <!-- Image link 1 -->
                                                <div class="form-group row col-lg-6 col-sm-12">
                                                    <label for="link1" class="col-lg-auto col-sm-12 col-form-label">Link1</label>
                                                    <div class="col-sm-12 col-lg-9">
                                                        <input type="text" class="form-control" name="link_1" value="<?php echo $section[0]->link_1; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="nl_image_content">
                                                <!-- upload one image -->
                                                <?php if(in_array($section[0]->section_type , array("MOSAIC","SUNGLASSES"))):?>
                                                <div class="row">
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="image2" class="col-sm-3 col-form-label">Image 2 </label>
                                                        <div class="col-sm-12 col-lg-9">
                                                            <input id="files" type="file" name="image2" class="form-control">
                                                    
                                                            <?php
                                                                    $file_name = $section[0]->image_2;
                                                                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                                                    if ($extension == "mp4")
                                                                    {
                                                            ?>

                                                            <span class="pip">
                                                                <video width="150" height="150" controls>
                                                                    <source
                                                                        src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" type="video/mp4">
                                                                </video>
                                                                <br><a
                                                                    href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a>
                                                            </span>
                                                                    
                                                            <?php
                                                                    }
                                                                    else
                                                                    {
                                                            ?>
                                                            <span class="pip">
                                                                <img class="imageThumb" src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" title="undefined"><br>
                                                                <!-- <a href="<?php echo base_url(); ?>/supercontrol/newsletter/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a> -->
                                                            </span>
                                                                    
                                                                    
                                                            <?php
                                                                    }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <!-- Image link 1 -->
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="link2" class="col-lg-auto col-sm-12 col-form-label">Link2</label>
                                                        <div class="col-sm-12 col-lg-9">
                                                            <input type="text" class="form-control" name="link_2" value="<?php echo $section[0]->link_2; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                                            
                                                <?php if(in_array($section[0]->section_type , array("MOSAIC"))):?>
                                                <div class="row">
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="image3" class="col-sm-3 col-form-label">Image 3 </label>
                                                        <div class="col-sm-12 col-lg-9 ">
                                                            <input id="files" type="file" name="image3" class="form-control">
                                                    
                                                            <?php
                                                                    $file_name = $section[0]->image_3;
                                                                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                                                    if ($extension == "mp4")
                                                                    {
                                                            ?>

                                                            <span class="pip">
                                                                <video width="150" height="150" controls>
                                                                    <source
                                                                        src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" type="video/mp4">
                                                                </video>
                                                                <br><a
                                                                    href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a>
                                                            </span>
                                                                    
                                                            <?php
                                                                    }
                                                                    else
                                                                    {
                                                            ?>
                                                            <span class="pip">
                                                                <img class="imageThumb" src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" title="undefined"><br>
                                                                <!-- <a href="<?php echo base_url(); ?>/supercontrol/newsletter/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a> -->
                                                            </span>
                                                                    
                                                                    
                                                            <?php
                                                                    }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <!-- Image link 1 -->
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="link3" class="col-lg-auto col-sm-12 col-form-label">Link3</label>
                                                        <div class="col-sm-12 col-lg-9">
                                                            <input type="text" class="form-control" name="link_3" value="<?php echo $section[0]->link_3; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                                            
                                                <?php if(in_array($section[0]->section_type , array("MOSAIC"))):?>
                                                <div class="row">
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="image4" class="col-sm-3 col-form-label">Image 4 </label>
                                                        <div class="col-sm-12 col-lg-9 ">
                                                            <input id="files" type="file" name="image4" class="form-control">
                                                    
                                                            <?php
                                                                    $file_name = $section[0]->image_4;
                                                                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                                                    if ($extension == "mp4")
                                                                    {
                                                            ?>

                                                            <span class="pip">
                                                                <video width="150" height="150" controls>
                                                                    <source
                                                                        src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" type="video/mp4">
                                                                </video>
                                                                <br><a
                                                                    href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a>
                                                            </span>
                                                                    
                                                            <?php
                                                                    }
                                                                    else
                                                                    {
                                                            ?>
                                                            <span class="pip">
                                                                <img class="imageThumb" src="<?php echo base_url(); ?>/assets/newsletter/y/<?php if ($file_name) echo $file_name; ?>" title="undefined"><br>
                                                                <!-- <a href="<?php echo base_url(); ?>/supercontrol/newsletter/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a> -->
                                                            </span>
                                                                    
                                                                    
                                                            <?php
                                                                    }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <!-- Image link 1 -->
                                                    <div class="form-group row col-lg-6 col-sm-12">
                                                        <label for="link4" class="col-lg-auto col-sm-12 col-form-label">Link4</label>
                                                        <div class="col-sm-12 col-lg-9">
                                                            <input type="text" class="form-control" name="link_4" value="<?php echo $section[0]->link_4; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                            </div>


                                           

                                    <!-- Submit button -->
                                    <div class="form-footer">
                                        <a href="<?php echo base_url(); ?>/supercontrol/newsletter/sections" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</a>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // function showDiv(divId, element) {
    //     document.getElementById(divId).style.display = element.value == 'Yes' ? 'flex' : 'none';
    //     document.getElementById("releaseDate").style.display = element.value == 'Yes' ? 'flex' : 'none';
    // }

    function showDiv(array, el) {

        array.forEach(element => {
            document.getElementById(element).style.display = el.value == 'Yes' ? 'flex' : 'none';
            $("#"+element+" .chosen-container").css({"width":"100%"})
        });
        // document.getElementById("releaseDate").style.display = element.value == 'Yes' ? 'flex' : 'none';
    }
       

</script>

<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor', {
        skin: 'moono',
        enterMode: CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        toolbar: [{
                name: 'basicstyles',
                groups: ['basicstyles'],
                items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']
            },
            {
                name: 'styles',
                items: ['Format', 'Font', 'FontSize']
            },
            {
                name: 'scripts',
                items: ['Subscript', 'Superscript']
            },
            {
                name: 'justify',
                groups: ['blocks', 'align'],
                items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            {
                name: 'paragraph',
                groups: ['list', 'indent'],
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
            },
            {
                name: 'links',
                items: ['Link', 'Unlink']
            },
            {
                name: 'insert',
                items: ['Image']
            },
            {
                name: 'spell',
                items: ['jQuerySpellChecker']
            },
            {
                name: 'table',
                items: ['Table']
            }
        ],
    });
</script>

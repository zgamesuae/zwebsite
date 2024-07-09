<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Newsletter extends \App\Controllers\BaseController
{
    public function header() {
        return view("/Supercontrol/Common/Header");
    }

    public function footer() {
        return view("/Supercontrol/Common/Footer");
    }

    public function index() {
      $productModel = model("App\Models\ProductModel");
      $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){    
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

      $crud->setCsrfTokenName(csrf_token());
      $crud->setCsrfTokenValue(csrf_hash());
      $crud->setTable("newsletter_instance");
      $crud->setSubject("newsletter", "newsletter");

      // $crud->addFields(['section_id','section_title','section_type','section_order']);
      $crud->unsetFields(["created_at", "updated_at","sent_to"]);
      // $crud->setRelation("promo_products" , "products", "name");
      // $crud->fieldType('promo_products', 'dropdown_search');
      $crud->fieldType('promo_products', 'multiselect_searchable', $productModel->get_product_list());
          
      // change the default insert
      // $crud->callbackInsert(function ($stateParameters){
      // });
        
    
      $crud->setActionButton('Preview', 'fa fa-file', function ($row) {
          return base_url().'/newsletter/show/' . $row->id;
          // var_dump($row->id);
      }, true);

        //   $crud->setActionButton('send', 'fa fa-paper-plane', function ($row) {
        //       if($row->status !=="SENT")
        //       return base_url().'/newsletter/send_scheduled/1/'.$row->id;
        //     // var_dump($row->id);
        //   }, false);

      $crud->setActionButton('Send test', 'fa fa-paper-plane-o', function ($row) {
          return base_url().'/newsletter/send_test/' . $row->id;
        // var_dump($row->id);
      }, false);

        // unset the SENT status from the fropdown
      $crud->fieldType('status', 'dropdown', array("DRAFT"=>"Draft","SCHEDULED"=>"Scheduled"));
      $crud->callbackColumn("sent_to",function($value,$row){
          if($value!==null && $value!==0)
          return $value."/total subscribers";
          else
          return "";
      });
       
      $output = $crud->render();
      return $this->_example_output($output);
    }

    private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header("Content-Type: application/json; charset=utf-8");
            echo $output->output;
            exit();
        }
        echo view("/Supercontrol/Common/Header", (array) $output);
        echo view("/Supercontrol/Crud.php", (array) $output);
        echo view("/Supercontrol/Common/Footer", (array) $output);
    }

    private function _getDbData() {
        $db = (new \Config\Database())->default;
        return [
            "adapter" => [
                "driver" => "Pdo_Mysql",
                "host" => $db["hostname"],
                "database" => $db["database"],
                "username" => $db["username"],
                "password" => $db["password"],
                "charset" => "utf8",
            ],
        ];
    }

    private function _getGroceryCrudEnterprise(){
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

    public function subscribers(){
      $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
            $access = $this->userModel->grant_access();
            if(is_array($access)){
                if ($access["addFlag"] == 0){
                    $crud->unsetAdd();
                }
                if ($access["editFlag"] == 0){
                    $crud->unsetEdit();
                }
                if ($access["deleteFlag"] == 0){
                    $crud->unsetDelete();
                    $crud->unsetDeleteMultiple();
                }
                if ($access["viewFlag"] == 0){
                    return view("errors/html/permission_denied");
                    exit;
                }
            }
        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("newsletter");
        $crud->setSubject("Subscriber", "Subscribers");

        $crud->unsetFields(["created_at", "updated_at"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function sections(){
        $nletter=model("App\Models\NewsletterModel");
        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

          $crud->setCsrfTokenName(csrf_token());
          $crud->setCsrfTokenValue(csrf_hash());
          $crud->setTable("newsletter_sections");
          $crud->setSubject("newsletter", "newsletter");
  
          $crud->setRelation("n_id" , "newsletter_instance", "subject");
          $uploadValidations = [
            'maxUploadSize' => '700k', // 20 Mega Bytes
            'minUploadSize' => '1K', // 1 Kilo Byte
            'allowedFileTypes' => [
                'gif', 'jpeg', 'jpg', 'png'
            ]
        ];

        foreach(array("image_1","image_2","image_3","image_4") as $v)
        $crud->setFieldUpload(
            $v, 
            'assets/newsletter', 
            base_url().'/assets/newsletter', 
            $uploadValidations
        );

          $crud->displayAs('n_id','Newsletter');
          $crud->unsetAdd();
          $crud->unsetEdit();
          $crud->unsetColumns(["link_1", "link_2","link_3","link_4"]);
          $crud->unsetFields(["section_title"]);

          $crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return base_url().'/supercontrol/newsletter/editsec/' . $row->id;
        }, false);

        


          $output = $crud->render();
          return $this->_example_output($output);
    }

    
    public function editsec($id=null,$msg=null){
        $userModel = model("App\Models\UserModel");
        $nl= model("App\Models\NewsletterModel");
        $validation = \Config\Services::validation();
        $data=array();

        // Access Check
          $access = $this->userModel->grant_access(false);
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                // $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                // $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                // $crud->unsetDelete();
                // $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        if ($this->request->getMethod() == "post") {
            $field_rules = [
                "n_id" => ["label" => "newsletter", "rules" => "required"],
                "section_title" => ["label" => "Section title", "rules" => "required"],
                "section_order" => ["label" => "Section order", "rules" => "required"],
                "section_type" => ["label" => "Section type", "rules" => "required"]
            ];

            // $images_rules=["images" => ["uploaded[images]"]];
            
            if($this->validate($field_rules)){
            // var_dump($this->request->getFile('image2'));die();

                $section_infos = $this->request->getVar();

                // $res=$userModel->do_action("newsletter_sections",$id,"id","update",array("image_1"=>"","image_2"=>null,"image_3"=>null,"image_4"=>null),"");

                if($this->request->getFile('image1') !== null && $this->request->getFile('image1')->getName() !== ""){
                    $image=$this->request->getFile('image1');
                    $image->move(ROOTPATH . '/assets/newsletter');
                    $section_infos["image_1"]=$image->getName();
                }
                
                if($this->request->getFile('image2') !== null && $this->request->getFile('image2')->getName() !== ""){
                    $image=$this->request->getFile('image2');
                    $image->move(ROOTPATH . '/assets/newsletter');
                    $section_infos["image_2"]=$image->getName();
                }

                if($this->request->getFile('image3') !== null && $this->request->getFile('image3')->getName() !== ""){
                    $image=$this->request->getFile('image3');
                    $image->move(ROOTPATH . '/assets/newsletter');
                    $section_infos["image_3"]=$image->getName();
                }

                if($this->request->getFile('image4') !== null && $this->request->getFile('image4')->getName() !== ""){
                    $image=$this->request->getFile('image4');
                    $image->move(ROOTPATH . '/assets/newsletter');
                    $section_infos["image_4"]=$image->getName();
                }

                $res=$userModel->do_action("newsletter_sections",$id,"id","update",$section_infos,"");
                // var_dump($res);

                if($res){

                    switch ($section_infos["section_type"]) {
                        case ($section_infos["section_type"] == 'BIG_SQUARE' || $section_infos["section_type"] == 'HORIZONTAL'):
                            # code...
                            $userModel->do_action("newsletter_sections",$id,"id","update",array("image_2"=>null,"image_3"=>null,"image_4"=>null),"");
                            break;

                        case 'SUNGLASSES':
                            # code...
                            $userModel->do_action("newsletter_sections",$id,"id","update",array("image_3"=>null,"image_4"=>null),"");
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    return redirect()->to("supercontrol/newsletter/sections");
                // return redirect()->to("/supercontrol/newsletter/editsec/".$id);

                }

                else{
                    $data["validation"][0] = "Something wrong happened, please try again";
                    if($section=$nl->get_section($id)){
                        $data["section"]=$section;
                    }
                    echo $this->header();
                    echo view('/Supercontrol/Addnssection',$data);
                    echo $this->footer();
                }
                // return redirect()->to("/supercontrol/newsletter/editsec/".$id);


            }

            else {
                $data["validation"] = $validation->getErrors();
                if($section=$nl->get_section($id)){
                    $data["section"]=$section;
                }
                echo $this->header();
                echo view('/Supercontrol/Addnssection',$data);
                echo $this->footer();
            }
            
        }

        else{


            if($section=$nl->get_section($id)){
                $data["section"]=$section;
            }
            echo $this->header();
            echo view('/Supercontrol/Addnssection',$data);
            echo $this->footer();
        }
    }

    public function addsection(){
        $userModel = model("App\Models\UserModel");
        $validation = \Config\Services::validation();
        $field_rules = [
            "n_id" => ["label" => "newsletter", "rules" => "required"],
            "section_title" => ["label" => "Section title", "rules" => "required"],
            "section_order" => ["label" => "Section order", "rules" => "required"],
            "section_type" => ["label" => "Section type", "rules" => "required"]
        ];

        // Access Check
        $access = $this->userModel->grant_access(false);
            if(is_array($access)){
              if ($access["addFlag"] == 0){
                  // $crud->unsetAdd();
              }
              if ($access["editFlag"] == 0){
                  // $crud->unsetEdit();
              }
              if ($access["deleteFlag"] == 0){
                  // $crud->unsetDelete();
                  // $crud->unsetDeleteMultiple();
              }
              if ($access["viewFlag"] == 0){
                  return view("errors/html/permission_denied");
                  exit;
              }
            }
        // Access Check

        $images_rules=["images" => ["uploaded[images]"]];
        // var_dump($this->request->getMethod());die();
        if ($this->request->getMethod() == "post") {
            // var_dump($this->validate($field_rules));die();
            if($this->validate($field_rules)){

                $section_infos = $this->request->getVar();
                $image1= $this->request->getFile('image1');
                $image2= $this->request->getFile('image2');
                $image3= $this->request->getFile('image3');
                $image4= $this->request->getFile('image4');

                $section_images = array($image1,$image2,$image3,$image4);
                

                foreach($section_images as $key => $image){
                    if($image !== null && $image->getName() !== ""){
                        $image->move(ROOTPATH . '/assets/newsletter');
                        // $userModel->do_action("nl_section_imgs","","","insert",array("name"=>$image->getName()),"");
                        $section_infos["image_".((int)$key+1)]=$image->getName();
                    }
                    
                    else{

                        switch ($section_infos["section_type"]) {
                            case 'MOSAIC':
                                # code...
                                $section_infos["image_".((int)$key+1)]="mosaic.png";
                                break;

                            case 'HORIZONTAL':
                                # code...
                                if( ((int)$key+1) == 1)
                                $section_infos["image_".((int)$key+1)]="horizontal.png";

                                break;

                            case 'BIG_SQUARE':
                                # code...
                                if(((int)$key+1) == 1)
                                $section_infos["image_".((int)$key+1)]="bigsquare.png";

                                break;

                            case 'SUNGLASSES':
                                # code...
                                if(((int)$key+1) <= 2)
                                $section_infos["image_".((int)$key+1)]="sunglasses.png";

                                break;
                            
                            default:
                                # code...
                                break;
                        }

                        
                    }
                    
                }
                
                
                // var_dump($section_infos);die();
                $res=$userModel->do_action("newsletter_sections","","","insert",$section_infos,"");
                
                if($res){
                    return redirect()->to("supercontrol/newsletter/sections");
                }

                else
                return redirect()->to("supercontrol/newsletter/addsection");
                

            }

            else var_dump($data["validation"] = $validation->getErrors());
            
        }
        else{
            echo $this->header();
            echo view('/Supercontrol/Addnssection');
            echo $this->footer();
        }
        
    }

    public function get_sectionimages($id){
        
        $nl_model=model("App\Models\NewsletterModel");
        echo json_encode($nl_model->get_newsletter_sec_imgs($id));
    }
  
}

    

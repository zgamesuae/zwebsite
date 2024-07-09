<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
class Category extends \App\Controllers\BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = model("App\Models\Category");
    }
    public function deleteImage()
    {
        $data = [];
        helper(["form", "url"]);
        $uri = service("uri");
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
            $uri2 = @$uri->getSegment(5);
            $res = $this->userModel->do_action(
                "category_image",
                $uri1,
                "id",
                "delete",
                "",
                ""
            );
            //   $this->session->setFlashdata('success', 'Category Deleted successfully!');
            return redirect()->to(
                site_url("supercontrol/Category/edit/" . $uri2 . "/image")
            );
        }
    }

    public function delete()
    {
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

      $data = [];
        helper(["form", "url"]);
        $uri = service("uri");
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
            $res = $this->userModel->do_action(
                "master_category",
                $uri1,
                "category_id",
                "delete",
                "",
                ""
            );
            $this->session->setFlashdata(
                "success",
                "Category Deleted successfully!"
            );
            return redirect()->to(site_url("supercontrol/Category"));
        }
    }

    public function edit()
    {
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

        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "category_name" => [
                    "label" => "Category Name",
                    "rules" => "required",
                ],
                "status" => [
                    "label" => "status",
                    "rules" => "required",
                ],
            ];
            if ($this->validate($rules)) {
                $p = $this->request->getVar();
                /*  $input = $this->validate([
                   'file' => [
                     'uploaded[file]',
                     'mime_in[file,image/jpg,image/jpeg,image/png]',
                   ]
                 ]);
                 if (!$input) {}else{
                   if($this->request->getFile('file')){
                    $img = $this->request->getFile('file');
                    $img->move(ROOTPATH.'/assets/uploads/');
                    $p['category_image']=$img->getName();
                  }
                }*/
                $input = $this->validate([
                    "file" => [
                        "uploaded[file]",
                        "mime_in[file,image/jpg,image/jpeg,image/png]",
                    ],
                ]);
                if (!$input) {
                } else {
                    if ($this->request->getFileMultiple("file")) {
                        foreach (
                            $this->request->getFileMultiple("file")
                            as $file
                        ) {
                            $file->move(ROOTPATH . "/assets/uploads/");
                            $pi["image"] = $file->getName();
                            $pi["category"] = $p["category_id"];
                            $resIMG = $this->userModel->do_action(
                                "category_image",
                                "",
                                "",
                                "insert",
                                $pi,
                                ""
                            );
                        }
                    }
                }
                if ($slug = $this->request->getVar("slug")) {
                    $p["slug"] = $this->categoryModel->createurl($slug);
                }
                unset($p["category_id"]);
                $res = $this->userModel->do_action(
                    "master_category",
                    $this->request->getVar("category_id"),
                    "category_id",
                    "update",
                    $p,
                    ""
                );
                $this->session->setFlashdata(
                    "success",
                    "Category updated successfully!"
                );
                return redirect()->to(site_url("supercontrol/Category"));
            } else {
                $data["validation"] = $validation->getErrors();
            }
        }
        echo $this->header();
        echo view("/Supercontrol/AddCategory");
        echo $this->footer();
    }

    public function add()
    {

      // Access Check
        $access = $this->userModel->grant_access();
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
        
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "category_name" => [
                    "label" => "Category Name",
                    "rules" => "required",
                ],
                "status" => [
                    "label" => "status",
                    "rules" => "required",
                ],
            ];
            if ($this->validate($rules)) {
                $p = $this->request->getVar();
                $p["category_id"] =
                    url_title($p["category_name"], "-", true) . "-" . time();
                /*  $input = $this->validate([
                   'file' => [
                     'uploaded[file]',
                     'mime_in[file,image/jpg,image/jpeg,image/png]',
                   ]
                 ]);
                 if (!$input) {}else{
                   if($this->request->getFile('file')){
                    $img = $this->request->getFile('file');
                    $img->move(ROOTPATH.'/assets/uploads/');
                    $p['category_image']=$img->getName();
                  }
                }*/
                $input = $this->validate([
                    "file" => [
                        "uploaded[file]",
                        "mime_in[file,image/jpg,image/jpeg,image/png]",
                    ],
                ]);
                if (!$input) {
                } else {
                    if ($this->request->getFileMultiple("file")) {
                        foreach (
                            $this->request->getFileMultiple("file")
                            as $file
                        ) {
                            $file->move(ROOTPATH . "/assets/uploads/");
                            $pi["image"] = $file->getName();
                            $pi["category"] = $p["category_id"];
                            $resIMG = $this->userModel->do_action(
                                "category_image",
                                "",
                                "",
                                "insert",
                                $pi,
                                ""
                            );
                        }
                    }
                }
                if ($slug = $this->request->getVar("slug")) {
                    $p["slug"] = $this->categoryModel->createurl($slug);
                }
                $res = $this->userModel->do_action(
                    "master_category",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                $this->session->setFlashdata(
                    "success",
                    "Category Added successfully!"
                );
                return redirect()->to(site_url("supercontrol/Category"));
            } else {
                $data["validation"] = $validation->getErrors();
            }
        }
        echo $this->header();
        echo view("/Supercontrol/AddCategory");
        echo $this->footer();
    }

    public function index()
    {
        // Access Check
          $access = $this->userModel->grant_access();
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

        echo $this->header();
        $sql = "select * from settings";
        $data["settings"] = $this->userModel->customQuery($sql);
        $data["flashData"] = $this->session->getFlashdata();
        echo view("/Supercontrol/Category", $data);
        echo $this->footer();
    }

    public function header()
    {
        return view("/Supercontrol/Common/Header");
    }

    public function footer()
    {
        return view("/Supercontrol/Common/Footer");
    }

    public function export()
    {
        // Access Check
          $access = $this->userModel->grant_access();
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

        $categoryModel = model("App\Models\Category");
        $userModel = model("App\Models\UserModel");

        $products = $userModel->customQuery(
            "select * from master_category where status='Active'"
        );

        $urls = $categoryModel->categories_urls();

        // echo(ROOTPATH."assets\exports\products.csv");die();
        $path = ROOTPATH . "assets/exports";
        if (!file_exists($path)) {
            $b = mkdir($path);
        }

        $csv = [["CATEGORY ID", "CATEGORY NAME", "HIERARCHY", "SLUG", "URL"]];
        foreach ($products as $key => $value) {
            # code...

            $ligne = [
                /* CATEGORY ID */     $value->category_id,
                /* TITLE */           $value->category_name,
                /* HIERARCHY */       $categoryModel->cat_hierarchy($value->category_id , false),
                /* SLUG */            $value->slug,
                /* URL */             base_url() . "/" . $urls[$value->category_id],
            ];

            array_push($csv, $ligne);
        }

        $file_name = "categories_export" . rand(555, 105000) . ".csv";
        $fp = fopen($path . "/" . $file_name, "a");

        foreach ($csv as $fields) {
            fputcsv($fp, $fields, ",");
        }

        fclose($fp);

        // return redirect()->to(site_url('/supercontrol/Products'));
        return redirect()->to(base_url() . "/assets/exports/" . $file_name);
    }

}

<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
class Home extends \App\Controllers\BaseController
{
    public function UpdateProfile()
    {
        helper(["form", "url"]);
        $p = $this->request->getVar();
        $input = $this->validate([
            "file" => [
                "uploaded[file]",
                "mime_in[file,image/jpg,image/jpeg,image/png]",
            ],
        ]);
        if (!$input) {
        } else {
            if ($this->request->getFile("file")) {
                $img = $this->request->getFile("file");
                $img->move(ROOTPATH . "/assets/uploads/");
                $p["image"] = $img->getName();
            }
        }
        $session = session();
        $admin_id = $session->get("adminLoggedin");
        $res = $this->userModel->do_action(
            "admin",
            $admin_id,
            "admin_id",
            "update",
            $p,
            ""
        );
        return redirect()->back();
    }

    public function index()
    {
      $session = session();
      $user = $session->get("adminLoggedin");
        // Access Check
          // $access = $this->userModel->grant_access(false);
          // if(is_array($access)){
            
          //   if ($access["viewFlag"] == 0){
          //       return view("errors/html/permission_denied");
          //       exit;
          //   }
          // }
            
          if(!$user || is_null($user))
            return view("errors/html/permission_denied");
          
          // return redirect()->to(site_url("supercontrol/login"));
        // Access Check

        echo $this->header();
        $sql = "select * from settings";
        $data["settings"] = $this->userModel->customQuery($sql);
        echo view("/Supercontrol/Home", $data);
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
}

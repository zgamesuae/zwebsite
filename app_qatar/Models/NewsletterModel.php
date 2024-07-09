<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class NewsletterModel extends Model{

    public $newsletter_content;
    private $subscribers;
    public $nid;
    public $schedule_time;
    public $nl_subject;
    public $userModel;

    public function __construct($nid=null){
        parent::__construct();
        $this->userModel = model("App\Models\UserModel");
    }

    public function initialise($nl_id=null,$promo_products=null)
    {
        // var_dump($this->get_nl_promo_products($nl_id));die();
        $newsletter=$this->get_newsletter_byID($nl_id);
        $this->nid = $nl_id;
        $this->newsletter_content = view("Newsletter",array(
            "settings" => $this->_getsociallinks(),
            "newsletter_info"=>$newsletter,
            "sections"=>$this->get_nl_sections($nl_id),
            "promoted_products" => $this->_getpromoted_products($this->get_nl_promo_products($nl_id))
        ));
        // $this->newsletter_content.=view("Newsletter_unsub",array("hashed_email"=>base64_encode("yahiaabd@gmail.com")));
        $this->subscribers = $this->_getsubscribers();
        $this->schedule_time=$newsletter->schedule_date;
        $this->nl_subject=$newsletter->subject;
    }

    public function _getsubscribers(){
        
        $subscribers =array();

        $req="select email from newsletter";
        $res = $this->userModel->customQuery($req);
        if($res){   
            foreach($res as $key=>$value){
                if(!is_null($value->email))
                array_push($subscribers, $value->email);
            }
            if(sizeof($subscribers) > 0)
            return $subscribers;
        }

        return $subscribers;
    }

    public function show_newsletter(){
        return $this->newsletter_content;
    }

    public function _getsociallinks(){
        

        $req="select * from settings";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        return null;
    }

    public function _getpromoted_products($set){
        
        
        // $req="select products.name,products.product_id,products.price,products.discount_percentage,product_image.image from products inner join product_image on products.product_id=product_image.product where products.precedence < 1000 AND FIND_IN_SET(5,products.type) AND products.status='Active' limit 15";

        $req="select products.name,products.product_id,products.price,products.discount_percentage,product_image.image from products inner join product_image on products.product_id=product_image.product where FIND_IN_SET(products.product_id,'".$set->promo_products."') AND products.status='Active' group by products.product_id order by products.name";
        // $req="select products.name,products.product_id,products.price,products.discount_percentage,images.image from products inner join (select image,product from product_image where FIND_IN_SET(product , '".$set->promo_products."') limit 1) as images on products.product_id=images.product where FIND_IN_SET(products.product_id,'".$set->promo_products."') AND products.status='Active' order by products.name";
        $res = $this->userModel->customQuery($req);
        if($res){
            return $res;
        }

        return null;
    }

    public function subscriber_exist($emailid){
        
        $req="select id from newsletter where email='".$emailid."'";

        $res=$this->userModel->customQuery($req);

        if($res)
        return $res[0]->id;
        else
        return false;
    }

    public function _unsubscribe($emailid){
        

        $res=$this->userModel->do_action("newsletter",$emailid,"id","update",array("status"=>"Unsubscribed"),"");

        return $res;
    }

    public function _subscribe($subscriber){
        
        if(!$this->subscriber_exist($subscriber["email"])){
            $res=$this->userModel->do_action("newsletter" , "" , "" , "insert" , $subscriber , "");
            if($res)
            return $res;
        }

        return false;
    }

    public function get_newsletter_byID($id){
        
        $req="select * from newsletter_instance where newsletter_instance.id=".$id;
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res[0];
        }

        else return false;
    }

    public function get_newsletters(){
        
        $req="select * from newsletter_instance";
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        else return false;
    }

    public function get_newsletter_sec_imgs($sec_id){
        
        $req="select image_1,image_2,image_3,image_4 from newsletter_sections where id=".$sec_id;
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res[0];
        }

        else return false;
    }

    public function get_section($id){
        
        $req="select * from newsletter_sections where id=".$id;
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        else return false;
    }

    public function has_valid_images($id){
        $section=$this->get_section($id);
        $bool=false;

        switch ($section[0]->section_type) {
            case 'MOSAIC':
                # code...
                if(($section[0]->image_1 !== null && $section[0]->image_1 !== "") && ($section[0]->image_2 !== null && $section[0]->image_2 !== "") && ($section[0]->image_3 !== null && $section[0]->image_3 !== "") && ($section[0]->image_4 !== null && $section[0]->image_4 !== ""))
                $bool=true;

                break;

            case 'SUNGLASSES':
                # code...
                if(($section[0]->image_1 !== null && $section[0]->image_1 !== "") && ($section[0]->image_2 !== null && $section[0]->image_2 !== ""))
                $bool=true;
                break;

            case ($section[0]->section_type="HORIZONTAL" || $section[0]->section_type="BIG_SQUARE"):
                # code...
                if($section[0]->image_1 !== null && $section[0]->image_1 !== "")
                $bool=true;
                break;
            
            default:
                # code...
                break;
        }

        return $bool;

    }
    
    public function get_nl_sections($id){
        
        $req="select * from newsletter_sections where n_id=".$id." order by section_order";
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        else return false;
    }

    public function get_nl_promo_products($id){
        
        $req="select promo_products from newsletter_instance where id=".$id;
        $res=$this->userModel->customQuery($req);

        if($res){
            return $res[0];
        }

        else return false;
    }

    public function get_scheduled_nl(){
        

        $req="select * from newsletter_instance where status='Scheduled'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        else return false;
    }

    public function set_status($status,$co){
        
        $res = $this->userModel->do_action("newsletter_instance",$this->nid,"id","update",array("status"=>"SENT","sent_to"=>$co),"");
    }


   
    

}



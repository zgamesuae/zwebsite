<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class ReviewModel extends Model{
    protected $userModel,$productModel;

    public function __construct(){
        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");


    }

    public function add_review($review){
        $session = session();
        $user_id = $session->get("userLoggedin");

        $user = $this->userModel->get_user($user_id);
        $product_id = $review["product"];
        $report = array(
            "status" => false,
            "message" => ""
        );
        if($user && $this->productModel->product_exist($product_id)){
            if($this->is_valid_review($review)){
                $data = array(
                    "product_id" => $product_id,
                    "user_id" => $user->user_id,
                    "user_name" => $user->name,
                    "rating" => $review["rating"],
                    "comment" => $review["review"],
                    "status" => "Inactive"
                );

                $bool = $this->userModel->do_action(
                    "product_review",
                    "",
                    "",
                    "insert",
                    $data,
                    ""
                );

                if($bool){
                    $report["status"] = true;
                }
                else{
                    $report["message"]= "Something went wrong";
                }
            }

            else{
                $report["message"] = "Review not valid";
            }
        }

        else
        $report["message"] = "Create account to leave a review";

        return $report;
    }



    public function is_valid_review($review){
        $rating = $review["rating"];
        $comment = $review["review"];

        if(is_int((int)$rating) && trim($comment) !== "")
        return true;

        return false;
    }

    public function get_product_reviews($id){

        $req="select * from product_review where product_id='".$id."' and status='Active'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        return false;
    }

    public function get_product_rating($id){
        $reviews = $this->get_product_reviews($id);
        $total_rating = $this->get_total_nbr_rating($id);

        $total = 0;
        if($reviews && $total_rating !== 0){
            foreach($reviews as $review){
                $total += $review->rating;
            }

            return ($total/$total_rating);
        }

        return 5;
    }

    public function get_total_nbr_rating($id){
        $req="select count(*) as nbr from product_review where product_id='".$id."' AND status='Active'";
        $res = $this->userModel->customQuery($req);

        if($res){
            if($res[0]->nbr > 0)
            return $res[0]->nbr;
        }

        return 1;
    }

   
}
<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
class Newsletter extends BaseController{

    public function show($id){
        $newsletter = model("App\Models\NewsletterModel");
        // echo("hello world");
        $newsletter->initialise($id);
        // var_dump($newsletter->schedule_time);
        $date= new \dateTime("now",new \DateTimeZone("Asia/Dubai"));
        $date1= new \dateTime($newsletter->schedule_time,new \DateTimeZone("Asia/Dubai"));

        // echo($date1->format("y-m-d H:i")."<br>");
        // echo($date->getTimestamp()."---- scheduled: ".$date1->getTimestamp());
        echo $newsletter->show_newsletter();
    }

    public function email_newsletter($s,$content,$s_email,$attach_unsub=true){
        $subject = $s;
        $message = $content;
        
        if($attach_unsub)
        $message.= view("Newsletter_unsub",array("hashed_email"=>base64_encode($s_email)));
        
        $email = \Config\Services::email();
        $email->setTo($s_email);
        $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            // echo 'Email successfully sent';
            return true;
        }

        return false;
    }

    public function send_test($n_instance_id){

        // initializing the newsletter instance
        $newsletter = model("App\Models\NewsletterModel");
        $newsletter->initialise($n_instance_id);
        $sent=false;
        // preparing the content and the subscribers list

       
        $test_list= array(
            // "divya.sharma@zamzamdistribution.com",
            // "muhammad.furqan@zamzamgames.com",
            // "zaeem.talha001@gmail.com",
            "yahia@3gelectronics.biz",
            "alantinedj@hotmail.fr",
            // "naqi@zamzamdistribution.com","m.nasir@zamzamdistribution.com"
        );

        if(sizeof($test_list) > 0){
            foreach($test_list as $s_email){
                // $report=$this->email_newsletter("Newsletter Test",$newsletter->show_newsletter(),$s_email);
                $report=$this->email_newsletter("TEST | ".$newsletter->nl_subject,$newsletter->newsletter_content,$s_email);
                if($report)
                $sent=true;
                // var_dump($report);
            }
        }

        if($sent)
        return redirect()->to("/supercontrol/newsletter/");

    }

    public function send_scheduled($send_now=null,$nl_id=null){
        $newsletter = model("App\Models\NewsletterModel");
        $subscribers = $newsletter->_getsubscribers();
        array_push($subscribers , "yahia@3gelectronics.biz");
        // $subscribers= array(
        //     "yahia@3gelectronics.biz"
        //     // "alantinedj@hotmail.fr"
        // );
        $timezone= new \DateTimeZone("Asia/Dubai");
        $current_datetime= new \DateTime("now",$timezone);
        $sent=false;

        if($send_now==null){
            // var_dump($subscribers);die();
                // get the scheduled newsletter
            $scheduled_newsletters = $newsletter->get_scheduled_nl();
            
            // set the current date information

            if($scheduled_newsletters){

                foreach($scheduled_newsletters as $s_newsletter){
                    
                    $newsletter->initialise($s_newsletter->id);
                    
                    $schedule_datetime = new \dateTime($newsletter->schedule_time,$timezone);
                    

                    $condition = ($schedule_datetime->getTimestamp() - $current_datetime->getTimestamp()) <= 0;
                    // var_dump($condition);die();

                    if($condition){
                       $co=0;
                        // loop on subscribers list and send the newsletter
                        if(sizeof($subscribers) > 0){
                            foreach($subscribers as $s_email){
                                // $report=$this->email_newsletter("Newsletter Test",$newsletter->show_newsletter(),$s_email);
                                $report=$this->email_newsletter($s_newsletter->subject,$newsletter->newsletter_content,$s_email);
                                if($report){
                                    $sent=true;
                                    $co++;
                                }
                                
                                
                            }
                            
                        }

                        if($sent || $co > 0){
                            $newsletter->set_status("SENT",$co);
                            return redirect()->to("/supercontrol/newsletter/");
                        }
                    }
                }
            }
        }

        else{
            $co=0;
            if($nl_id !== null){
                
                $newsletter->initialise($nl_id);

                if(sizeof($subscribers) > 0){
                    foreach($subscribers as $s_email){
                        // $report=$this->email_newsletter("Newsletter Test",$newsletter->show_newsletter(),$s_email);
                        $report=$this->email_newsletter($newsletter->nl_subject,$newsletter->newsletter_content,$s_email);
                        if($report){
                            $sent=true;
                            $co++;
                        }
                        
                        // var_dump($report);
                    }
                }

                if($sent || $co > 0){
                    $newsletter->set_status("SENT",$co);
                    return redirect()->to("/supercontrol/newsletter/");
                }
            }
        }
    

        
        


    }

    public function unsubscribe($emailhash){
        $newsletter = model("App\Models\NewsletterModel");
        $delete_status=false;
        
        $emailhash = base64_decode($emailhash);
        // var_dump($newsletter->subscriber_exist($emailhash));die();
        if($subscriber = $newsletter->subscriber_exist($emailhash)){
            
            $delete_status = $newsletter->_unsubscribe($subscriber);
        }

        if($delete_status){
            return redirect()->to(base_url()."/newsletter/unsubscribed_page");
        }
        else{
            return redirect()->to("https://zamzamgames.com");
        }
    }

    public function unsubscribed_page(){
        echo view("Common/Header");
        echo view("newsletter/Unsubscribed");
        echo view("Common/Footer");

    }

    public function cart_notification($duration){
        $orderModel = model("App\model\OrderModel");
        
        $ab = $orderModel->get_users_abondoned_carts($duration);
        if(sizeof($ab)>0 && !is_null($ab)){

            foreach($ab as $value){
                $cart = $orderModel->get_user_cart($value["id"]);
                if(sizeof($cart)>0){
                    // send the email to the customer
                    // var_dump($value);
                    $email_content = view("Cart_notification" , array("infos" =>[
                                        "user"=>$value,
                                        "carts_product"=>$cart,
                                        ] ));
                    $this->email_newsletter("Your Items are waiting - ZGAMES" , $email_content , $value["email"] , false);
                                        
                }


            }

        }
    }

}
<?php
$session = session();
$userModel = model("App\Model\UserModel");
$orderModel = model("App\Model\OrderModel");
$user_id = $session->get("userLoggedin");

if($user_id){
    switch ($flag) {
        case 'change':
        # code...
        $addresses = $userModel->get_user_addresses($user_id); 
        if(isset($addresses) && sizeof($addresses) > 0){
            $display="<div class='row col-12 m-0 mt-4'>";
            $i = 1;
            $display .= '
                <div class="row col-12 m-0 justify-content-center align-items-center">
                    <p class="col-auto" style="font-size: 1.3rem">Choose address</p>
                </div>
                <form action="" method="post" class="ws-change-addrss-form">
            ';
            foreach($addresses as $address){
                $checked = ($address->status == 'Active') ? 'checked' : '';
                $display .= '
                    <div class="row col-12 m-0 my-1 justify-content-between align-items-center">
                        <div class="form-check align-content-center">
                            <input class="form-check-input" type="radio" value="'.$address->address_id.'" id="address-'.$address->address_id.'" name="addrss-radio" '.$checked.'>
                            <label class="form-check-label row m-0" for="address-'.$address->address_id.'">
                                <div>
                                    <span>'.$address->name.'</span>
                                </div>
                                <div class="col-12 p-0">
                                    <span style="font-weight: 200; font-size: .8rem">
                                    <i class="fa-sharp fa-solid fa-location-dot"></i>
                                    '.$address->street.' '.$address->apartment_house.', '.$orderModel->get_city_name($address->city)->title.'
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                ';

                if($i < sizeof($addresses))
                $display .= "<hr class='col-12 p-0' style='background-color: #ffffff3b'>";

                $i++;
            }

            $display .= '
                    <div class="row col-12 m-0 mt-3 justify-content-center align-items-center">
                        <input type="submit" value="Submit" class="rounded d-flex justify-content-center btn bg-secondary col-5">
                    </div>
                </form>

            ';

            $display .="</div>";

            echo $display;
        }

        break;
    
        case 'add':
        # code...
        echo ("Add new address from");
        break;
    
        default:
        # code...
        break;
    }
}



?>
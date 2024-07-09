<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class WalletModel extends Model{


    public function telr_payment($params){
        $telr_data = ["status"  => false , "url" => null , "ref" => null];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if (curl_exec($ch) === false) {
            echo "Curl error: " . curl_error($ch);
        } 

        else {
            $results = json_decode(curl_exec($ch), true);
            $ref_cond = isset($results["order"]["ref"]) && $results["order"]["ref"] !== "";
            $url_cond = isset($results["order"]["url"]) && $results["order"]["url"] !== "";

            if($ref_cond && $url_cond){
                $ref = trim(@@$results["order"]["ref"]);
                $url = trim(@@$results["order"]["url"]);
                // $ptp["order_id"] = $idata["order_id"];
                // $ptp["ref"] = $ref;
                // $ptp["link"] = $url;
                // $ptp["customer"] = $idata["user_id"];
                // $res = $userModel->do_action("payment_txn", "", "", "insert", $ptp, "");
                $telr_data["status"] = true;
                $telr_data["url"] = $url;
                $telr_data["ref"] = $ref;
            }
            
        }
        curl_close($ch);

        return $telr_data;
    }


    public function wallet_transaction_check($ref){
        $transaction = ["status" => null , "ref" => null ];
        $params = [
            "ivp_method" => "check",
            "ivp_store" => STOREID,
            "ivp_authkey" => AUTHKEY,
            "order_ref" => $ref,
            "ivp_test" => PGTEST,
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Expect:"]);

        if (curl_exec($ch) === false) {
            echo "Curl error: " . curl_error($ch);
        } 
        else {
            $results = json_decode(curl_exec($ch), true);
        }
        curl_close($ch);

        if($results && $results["order"]["status"]["text"] == "Paid"){
            $transaction["status"] = "Paid";
            $transaction["ref"] = @$results["order"]["transaction"]["ref"];
        }

        return $transaction;
    }
}